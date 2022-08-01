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

class SubjectAssignmentController extends Controller
{
    use NotificationTrait;
    use MessageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($subject_id)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subject_id)
    {
        $subject = Subject::findOrFail($subject_id);
        return view('subject.assignment.create', compact('subject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $subject_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'due_date' => 'date',
            'file_upload' => 'file'
        ]);
        $extension = Input::file('file_upload')->getClientOriginalExtension();
        $filename = Auth::user()->id . '.' .$request['name']. '.' .time(). '.' . $extension;
        $path = $request->file('file_upload')->storeAs('/public/files/assignments/', $filename);
  
        $assignment = new Assignment;
        $assignment->subject_id = $subject_id;
        $assignment->name = $request['name'];
        $assignment->due_date = $request['due_date'];
        $assignment->file_path = $filename;
        $assignment->user_id = Auth::user()->id;
        $assignment->save();
        $this->assign_student($assignment);

        $activity = new TeacherActivity;
        $activity->log = 'Created a new assignment';
        $activity->url = '/assignment/' . $assignment->subject_id;
        $activity->user_id = Auth::id();
        $activity->save();

        return redirect('assignment/' . $assignment->subject_id)->with('message','Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subject_id, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subject_id, $id)
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
    public function update(Request $request, $subject_id, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subject_id, $id)
    {
        //
    }

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

        $title = $assignment->subject->name;
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
}
