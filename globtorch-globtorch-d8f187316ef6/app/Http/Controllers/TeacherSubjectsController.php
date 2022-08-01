<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Subject;
use App\Course;
use App\TeacherSubject;

use App\Traits\NotificationTrait;

class TeacherSubjectsController extends Controller
{
    use NotificationTrait;

    /**
     * Display a listing of the resource.
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
            
        return view('teacher.my_subjects', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $teacher = User::find($id);
        $courses = Course::all();
        $teacher_subjects_id = TeacherSubject::where('user_id', $teacher->id)->pluck('subject_id')->toArray();
        return view('teacher_subjects.create',compact('teacher','courses', 'teacher_subjects_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $teacher = User::find($request->input("teacher_id"));
        $subjects =Subject::all();
        $teacher_subject_ids = TeacherSubject::where('user_id', $teacher->id)
                                            ->pluck('subject_id')
                                            ->toArray();
        foreach ($subjects as $subject) 
        {
            if ($request[$subject->id]) 
            {
                if (!(in_array($subject->id, $teacher_subject_ids)))
                {
                    $teacher_subject = new TeacherSubject;
                    $teacher_subject->subject_id = $subject->id;
                    $teacher_subject->user_id = $teacher->id;
                    $teacher_subject->save();

                    //notify the teacher that a subject has been added to them
                    $title = "Subject Assigned";
                    $body = $teacher_subject->subject->name;
                    $link = "/teacher_subjects";
                    $users = array($teacher);
                    $this->create_notification($title, $body, $link, $users, 0);
                }
            }
            else
            {
                if (in_array($subject->id, $teacher_subject_ids))
                {
                    $teacher_subject = TeacherSubject::where([
                        ['user_id', '=' ,$teacher->id], 
                        ['subject_id', '=' , $subject->id]
                    ])->get()->first();

                    $teacher_subject->delete();

                    //notify the teacher that a subject has been removed from them
                    $title = "Subject Unassigned";
                    $body = $teacher_subject->subject->name;
                    $link = "/teacher_subjects";
                    $users = array($teacher);
                    $this->create_notification($title, $body, $link, $users, 0);
                }
            }
        }

        return redirect('/teacher')->with('message', 'Your request was successful');
    }
}
