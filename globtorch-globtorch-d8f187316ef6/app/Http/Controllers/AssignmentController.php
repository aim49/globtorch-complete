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
use App\TeacherSubject;
use App\TeacherActivity;
use App\MessageLog;

use App\Traits\NotificationTrait;
use App\Traits\MessageTrait;

class AssignmentController extends Controller
{
    use NotificationTrait;
    use MessageTrait;

    public function show_subjects()
    {
        //get all the subjects for teacher
        $teacher = User::with('subjects')->find(Auth::user()->id);
        $subject_ids = $teacher->subjects->pluck('id')->toArray();
        $courses = Course::join('course_subject', 'courses.id', 'course_subject.course_id')
            ->join('subjects', 'course_subject.subject_id', 'subjects.id')
            ->join('teacher_subjects', 'subjects.id', 'teacher_subjects.subject_id')
            ->select('courses.*')
            ->where('teacher_subjects.user_id', Auth::id())
            ->distinct()
            ->get();
        return view('assignment.subjects',compact('courses', 'subject_ids'));
    }

    /**
     * Display a listing of the resource.
     * @param id of the subject
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $subject = Subject::with('assignments')->find($id);
        return view('assignment.index',compact('subject'));
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //view for add a new assignment for a subject
        $subjects = Subject::find($id);
        return view('assignment.create',compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $extension = Input::file('file_upload')->getClientOriginalExtension();
        //format user_id + name + time
        $filename = Auth::user()->id . '.' .$request['name']. '.' .time(). '.' . $extension;
        $path = $request->file('file_upload')->storeAs('/public/files/assignments/', $filename);
  
        $assignment = new Assignment(array(
             'subject_id'=> $request['subject_id'],
             'name' => $request['name'],
            'due_date' =>$request['due_date'],
            'file_path' => $filename,
            'user_id' => Auth::user()->id,
        ));
        $assignment->save();
        $this->assign_student($assignment);

        //logging the teacher activity
        $activity = new TeacherActivity;
        $activity->log = 'Created a new assignment';
        $activity->url = '/assignment/' . $assignment->subject_id;
        $activity->user_id = Auth::id();
        $activity->save();

        // return to the subject assignment
        return redirect('assignment/' . $assignment->subject_id)->with('message','Successfully Added');
    }

    /**
     * When we create a new assignment we should add the student to the assignment
     * Then notify the student that an assignment has been added
     */
    private function assign_student($assignment)
    {
        $today = date('Y-m-d');
        $students = User::join('enrollments', 'users.id', 'enrollments.user_id')
            ->join('payments', 'enrollments.id', 'payments.enrollment_id')
            ->join('courses', 'courses.id', 'enrollments.course_id')
            ->join('subjects', 'courses.id', 'subjects.course_id')
            ->where('subjects.id', $assignment->subject_id)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->select('users.*')
            ->get();

        $title = $assignment->subject->course->name . "- " . $assignment->subject->name;
        $body = "New assignment given due on " . $assignment->due_date;
        $link =  route('view_studentassignment', $assignment->subject_id);
        $message = $title . ' ' . $body . ' ' . $link;

        foreach ($students as $student)
        {
            $assignment_answer = new AssignmentAnswer;
            $assignment_answer->assignment_id = $assignment->id;
            $assignment_answer->user_id = $student->id;
            $assignment_answer->save();
            $this->send_message($student->phone, $message);
        }
        $messageLog = new MessageLog;
        $messageLog->purpose = 'new assignment';
        $messageLog->number = count($students);
        $messageLog->save();
        
        $this->create_notification($title, $body, $link, $students, 0);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignment::find($id);
        return Storage::download('/public/files/assignments/'.$assignment->file_path);
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //view for edit assignment 
        $assignments = Assignment::find($id);
        return view('assignment.edit',compact('assignments'));
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
        // update the assignment details
        $assignment = Assignment::find($id);
        
        if ($request['edit'] == '1')
        {
            //get new file
            $extension = Input::file('file_upload')->getClientOriginalExtension();
            //format user_id + name + time
            $filename = Auth::user()->id . '.' .$request['name']. '.' .time(). '.' . $extension;
            $path = $request->file('file_upload')->storeAs('/public/files/assignments/', $filename);
    
            //delete old file
            Storage::delete('/public/files/assignments/'.$assignment->file_path);
        }
        else
        {
            $filename = $assignment->file_path;
        }  
        
        $assignment->update([
            'user_id'=>$request['user_id'],
            'subject_id'=> $request['subject_id'],
            'name'=>$request['name'], 
            'due_date'=>$request['due_date'],
            'file_path'=>$filename
        ]);

        //logging the teacher activity
        $activity = new TeacherActivity;
        $activity->log = 'Updated an assignment';
        $activity->url = '/assignment/' . $assignment->subject_id;
        $activity->user_id = Auth::id();
        $activity->save();

        //notifying students
        $today = date('Y-m-d');
        $students = User::join('enrollments', 'users.id', 'enrollments.user_id')
            ->join('payments', 'enrollments.id', 'payments.enrollment_id')
            ->join('courses', 'courses.id', 'enrollments.course_id')
            ->join('course_subject', 'course_subject.course_id', 'courses.id')
            ->join('subjects', 'course_subject.subject_id', 'subjects.id')
            ->where('subjects.id', $assignment->subject_id)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->select('users.*')
            ->get();
        $title = $assignment->subject->name;
        $body = "An assignment has been updated and is due on " . $assignment->due_date;
        $link =  route('view_studentassignment', $assignment->subject_id);
        $message = $title . ' ' . $body . ' ' . $link;

        foreach ($students as $student)
        {
            $this->send_message($student->phone, $message);
        }
        $messageLog = new MessageLog;
        $messageLog->purpose = 'updated assignment';
        $messageLog->number = count($students);
        $messageLog->save();
        
        $this->create_notification($title, $body, $link, $students, 0);

        return redirect('assignment/' . $request['subject_id'])->with('message','Updated Successfully');
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
