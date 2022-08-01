<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Discussion;
use App\Subject;
use App\User;
use App\Comment;
use App\TeacherActivity;
use App\Course;

use App\Traits\NotificationTrait;

class DiscussionController extends Controller
{
    use NotificationTrait;

    /**
     * Listing all the subjects that a teacher has
     * to add and view discussions
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::join('course_subject', 'courses.id', 'course_subject.course_id')
            ->join('subjects', 'course_subject.subject_id', 'subjects.id')
            ->join('teacher_subjects', 'subjects.id', 'teacher_subjects.subject_id')
            ->join('users', 'teacher_subjects.user_id', 'users.id')
            ->select('courses.id', 'courses.name', 
                'subjects.id as subject_id', 'subjects.name as subject')
            ->where('users.id', Auth::id())
            ->orderBy('courses.name')
            ->orderBy('courses.id')
            ->orderBy('subjects.name')
            ->get();
        return view('discussion.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $subject_details=Subject::where('id',$id)->get();
        return view('discussion.create',compact('subject_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'body' => 'required',
            'id' => 'required'
        ]);

        $discussion = new Discussion();
        $discussion->title = $request->title;
        $discussion->body = $request->body;
        $discussion->subject_id = $request->id;
        $discussion->user_id = Auth::user()->id;
        $discussion->save();

        //notifying all the users that a discussion has started.
        $teachers = $discussion->subject->users;
        $users = User::join('enrollments', 'enrollments.user_id', 'users.id')
            ->join('courses', 'courses.id', 'enrollments.course_id')
            ->join('course_subject', 'course_subject.course_id', 'courses.id')
            ->where('course_subject.subject_id', $discussion->subject_id)
            ->get();
        foreach($teachers as $teacher)
        {
            $users->push($teacher);
        }
        $title = "Discussion started";
        $body = $discussion->title;
        $link = "/view_discussion/" . $discussion->id;
        $this->create_notification($title, $body, $link, $users, Auth::user()->id);

        if (Auth::user()->user_type == 'teacher')
        {
            $activity = new TeacherActivity;
            $activity->log = 'started discussion';
            $activity->url = "/view_discussion/" . $discussion->id;
            $activity->user_id = Auth::id();
            $activity->save();
        }

        return redirect()->route('view_discussion', $discussion->id);
    }

    /**
     * Displays all discussions for a subject
     */
    public function show($id)
    {
        $subject = Subject::find($id);
        $discussions = $subject->discussions;
        return view('discussion.show',compact('subject', 'discussions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discussion = Discussion::find($id);
        return view('discussion.edit',compact('discussion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title'=>'required',
            'body' => 'required'
        ]);

        $discussion = Discussion::find($id);
        $discussion->title = $request->input('title');
        $discussion->body = $request->input('body');
        $discussion->save();

        if (Auth::user()->user_type == 'teacher')
        {
            $activity = new TeacherActivity;
            $activity->log = 'updated discussion';
            $activity->url = "/view_discussion/" . $discussion->id;
            $activity->user_id = Auth::id();
            $activity->save();
        }

        return redirect('/discussion/' . $discussion->subject_id)->with('message','Discussion posts successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discussion=Discussion::where('id',$id)->delete();
        return redirect()->route('view_discussions');
    }

    /** STUDENT DISCUSSION SECTION **/

    //viewing discussions
    public function discussions()
    {
        $student = User::find(Auth::user()->id);
        $courses = $student->courses;
        return view('student.discussions', compact('courses'));
    }
    
    //viewing selected discussion
    public function view_discussion($id)
    {
        $discussion=Discussion::find($id);
        return view('discussion.view',compact('discussion'));
    }

    //commenting a discussion
    public function comment(Request $request,$id)
    {
        //checking if the student has an active subscription
        if (Auth::user()->user_type == "student")
        {
            $today = date('Y-m-d');
            $subscriptions = DB::table('users')
                ->join('enrollments', 'users.id', '=' , 'enrollments.user_id')
                ->join('payments', 'enrollments.id', '=', 'payments.enrollment_id')
                ->join('courses', 'courses.id', '=', 'enrollments.course_id')
                ->join('subjects', 'courses.id', '=', 'subjects.course_id')
                ->join('chapters', 'subjects.id', '=', 'chapters.subject_id')
                ->join('topics', 'chapters.id', '=', 'topics.chapter_id')
                ->join('discussions', 'subjects.id', '=', 'discussions.subject_id')
                ->select('payments.*')
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->where('discussions.id', '=', $id)
                ->where('users.id', '=', Auth::user()->id)
                ->orderBy('end_date')->get();

            if (count($subscriptions) == 0)
            {
                return back()->withErrors('You do not have an active subscription!');
            }
        }

        $discussion=Discussion::find($id);
        $comment=new Comment();
        $comment->comment=request('body');
        $comment->discussion_id=$discussion->id;
        $comment->user_id=Auth::user()->id;
        $comment->save();

        //notifying all the students who are registered on the course about the discussion
        $teachers = $discussion->subject->users;
        $users = User::join('enrollments', 'enrollments.user_id', 'users.id')
            ->join('courses', 'courses.id', 'enrollments.course_id')
            ->join('course_subject', 'course_subject.course_id', 'courses.id')
            ->where('course_subject.subject_id', $discussion->subject_id)
            ->get();
        foreach($teachers as $teacher)
        {
            $users->push($teacher);
        }
        $title = "Discussion- " . $discussion->title;
        $body = "New comment added by: " . Auth::user()->name . " " . Auth::user()->surname;
        $link = "/view_discussion/" . $discussion->id;
        $this->create_notification($title, $body, $link, $users, Auth::user()->id);

        //logging the teacher activity
        if (Auth::user()->user_type == 'teacher')
        {
            $activity = new TeacherActivity;
            $activity->log = 'Commented on discussion';
            $activity->url = "/view_discussion/" . $discussion->id;
            $activity->user_id = Auth::id();
            $activity->save();
        }

        return back();
    }
}
