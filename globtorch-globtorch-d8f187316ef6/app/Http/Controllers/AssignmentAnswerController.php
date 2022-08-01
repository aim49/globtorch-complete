<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Response;
use App\Subject;
use App\User;
use App\Course;
use App\Assignment;
use App\AssignmentAnswer;
use App\Enrollment;
use App\TeacherActivity;
use App\MessageLog;

use App\Traits\NotificationTrait;
use App\Traits\MessageTrait;

class AssignmentAnswerController extends Controller
{
    use NotificationTrait;
    use MessageTrait;

    /**
     * Student viewing all courses
     */
    public function get_courses()
    {
        $student = User::with('courses')->find(Auth::user()->id);
        $enrolled_courses = $student->courses;
        return view('assignment.studentassign', compact('enrolled_courses'));
    }

    /**
     * Student viewing all subjects 
     */
    public function showsubjects($id)
    {
        $course = Course::with('subjects')->findOrFail($id);

        return view('assignment.viewsubjects',compact('course'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //getting all the courses that the student is enrolled on and are active 
            $student = User::find(Auth::user()->id);
            $enrolled_courses = Enrollment::where('user_id', $student->id)
            ->select( 'courses.id', 'courses.name', 'courses.description', 'courses.level')
            ->join('payments', 'payments.enrollment_id', 'enrollments.id')
            ->join('courses', 'courses.id', 'enrollments.course_id')
            ->where('payments.start_date','<=',date('Y-m-d') )
            ->where('payments.end_date','>=',date('Y-m-d') )
            ->where('enrollments.status','!=','complete')
            ->orderBy('payments.id', 'asc')
            ->get();
            return view('assignment.studentassign',compact('enrolled_courses'));
    }
    public function submit($id)
    {
        //view for submit assignment file for a certain assignment
        $assignments = Assignment::find($id);
        return view('assignment.submitassignment',compact('assignments'));
       
    }
    public function editsubmit($id)
    {
        //view for edit submitted assignment for a student
        $assignmentanswer = AssignmentAnswer::find($id);
        $assignments = Assignment::where('id', $assignmentanswer->assignment_id)
        ->get();
        return view('assignment.editsubmittedassignment',compact('assignments','assignmentanswer'));
     
    }
    public function marks($id)
    {
        //view for add mark and marked file for a certain student
        $assignments = AssignmentAnswer::find($id);
        return view('assignment.marks',compact('assignments'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $assignment_id = $request['assignment_id'];
        $user_id = Auth::user()->id;

        // this is for storing the new assignment answer for a student
        $extension = Input::file('file_upload')->getClientOriginalExtension();
        //format user_id + assignment_id + time
        $filename = $user_id . '.' .$assignment_id. '.' .time().  '.' . $extension;
        $path = $request->file('file_upload')->storeAs('/public/files/assignments/', $filename);

        $assignmentmark = AssignmentAnswer::where([
            ['assignment_id', $assignment_id],
            ['user_id', $user_id]
            ])->get()->first();
        $assignmentmark->file_path = $filename;
        $assignmentmark->mark = 0;
        $assignmentmark->save();
        // return to the subject assignment
        $assignment = Assignment::with('subject')->find($assignment_id);

        $title = $assignment->subject->name;
        $body = "Assignment Submitted";
        $link =  route('add_assignments_mark', $assignmentmark->id);
        $message = $title . ' ' . $body . ' ' . $link;
        $this->send_message($assignment->user->phone, $message);
        $messageLog = new MessageLog;
        $messageLog->purpose = 'student submitted assignment';
        $messageLog->number = 1;
        $messageLog->save();
        
        $this->create_notification($title, $body, $link, array($assignment->user), 0);
        return redirect('assignment/viewassign/' . $assignment->subject_id)->with('message','Successfully Submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id (subject_id)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //view for get all the assignments for a certain subject and all the students enrolled
        /*
        $assignments = Assignment::where('subject_id',$id)
                                ->orderBy('due_date', 'desc')
                                ->get();
        */
        $user = Auth::user();
        $today = date('Y-m-d');
        if ($user->user_type == 'student')
        {
            $payments = \App\Payment::join('enrollments', 'enrollments.id', 'payments.enrollment_id')
                ->join('courses', 'courses.id', '=', 'enrollments.course_id')
                ->join('course_subject', 'course_subject.course_id', 'courses.id')
                ->join('subjects', 'course_subject.subject_id', '=', 'subjects.id')
                ->where('subjects.id', $id)
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->where('user_id', $user->id)
                ->get();
            if (count($payments) == 0)
            {
                return redirect()->back()->withErrors('No active subscription, you are not allowed to view this page');
            }
        }
        $assignments = DB::table('assignments')
                        ->select('assignments.*', 
                                'assignment_answers.id as answer_id', 'mark', 'assignment_answers.file_path as answer',
                                'assignment_answers.marked_answer')
                        ->join('assignment_answers', 'assignments.id', '=', 'assignment_answers.assignment_id')
                        ->where([
                                ['subject_id', '=', $id],
                                ['assignment_answers.user_id', '=', Auth::id()]
                            ])
                        ->where(function($query) use ($today){
                            $query->where('due_date', '>=', $today)
                                ->orWhere('assignment_answers.file_path', '!=', null);
                        })
                        ->orderBy('due_date', 'desc')
                        ->get();
        $subject_name = Subject::find($id)->name;
        return view('assignment.viewassign',compact('assignments', 'subject_name'));
    }
    
    public function getassign($id)
    {
        $assignment = Assignment::find($id);
        return view('assignment.getassignanswer',compact('assignment'));
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'mark' => 'integer|required'
        ]);
        $assignment = AssignmentAnswer::find($id);

        if ($request['edit'] == '1')
        {
            $request->validate([
                'file_upload' => 'file'
            ]);
            Storage::delete('public/files/assignments/'.$assignment->marked_answer);
        }

        if ($assignment->marked_answer == null || $request['edit'] == 1)
        {
            $request->validate([
                'file_upload' => 'file'
            ]);

            $extension = Input::file('file_upload')->getClientOriginalExtension();
            $filename = $id. '.' .time().  '.' . $extension;
            $path = $request->file('file_upload')->storeAs('/public/files/assignments/', $filename);
            $assignment->marked_answer = $filename;
        }
        
        $assignment->mark = $request->input('mark');
        $assignment->save();

        return redirect('assignment/getassignanswer/' . $assignment->assignment_id)->with('message','Successfully Saved');
    }
   
    public function updateassignmentmark(Request $request,  $id)
    {
       // this is for updating assignment answer file student side
        $assignments=AssignmentAnswer::find($id);
           
        if ($request['edit'] == '1')
        {
            //delete saved file
            Storage::delete('/public/files/assignments/'.$assignments->file_path);
            //get file
            $extension = Input::file('file_upload')->getClientOriginalExtension();
            //format user_id + assignment_id + time
            $filename = $assignments->user_id . '.' . $assignments->assignment_id . '.' .time().  '.' . $extension;
            $path = $request->file('file_upload')->storeAs('/public/files/assignments/', $filename);
            
        }
        else
        {
            $filename = $assignments->file_path;
        }  
        $assignments->file_path = $filename;
        $assignments->save();

        //logging the teacher activity
        if (Auth::user()->user_type == 'teacher')
        {
            $activity = new TeacherActivity;
            $activity->log = 'Updated assignment marks';
            $activity->url = 'assignment/viewassign/' . $assignments->assignment->subject_id;
            $activity->user_id = Auth::id();
            $activity->save();
        }

       //return to subjects
       return redirect('assignment/viewassign/' . $assignments->assignment->subject_id)->with('message','Updated Successfully');
    }

    public function download($id)
    {
        $assignment = AssignmentAnswer::find($id);
        return Storage::download('/public/files/assignments/'.$assignment->file_path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
