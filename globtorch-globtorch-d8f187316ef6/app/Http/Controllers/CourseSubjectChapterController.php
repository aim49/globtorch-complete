<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;
use App\Subject;
use App\Chapter;

use App\Traits\NotificationTrait;

class CourseSubjectChapterController extends Controller
{
    use NotificationTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id, $subject_id)
    {
        $course = Course::findOrFail($course_id);
        $subject = Subject::with('chapters')->findOrFail($subject_id);
        return view('course.subject.chapter.index', compact('course', 'subject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id, $subject_id)
    {
        $course = Course::findOrFail($course_id);
        $subject = Subject::with('chapters')->findOrFail($subject_id);
        return view('course.subject.chapter.create', compact('course', 'subject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $course_id, $subject_id)
    {
        $this->validate($request,[
            'name'=>'required',
            'order' => 'required'
            ]);

        $subject = Subject::with('chapters')->find($subject_id);
        $order = $request->input('order');
        if (count($subject->chapters) > 0)
        {
            $chapters = $subject->chapters->sortBy('order');

            if ($order < 1 || $order > ($chapters->last()->order + 1))
            {
                $order = $chapters->last()->order + 1;
            }

            if ($chapters->last()->order + 1 != $order)
            {
                foreach($chapters as $chapter)
                {
                    if ($chapter->order >= $order)
                    {
                        $chapter->order++;
                        $chapter->save();
                    }
                }
            }
        }

        $chapter = new Chapter;
        $chapter->name = $request->input('name');
        $chapter->order = $order;
        $chapter->subject_id = $subject_id;
        $chapter->save();

        $course = Course::with('users')->findOrFail($course_id);
        $title = $course->name . "- " . $subject->name;
        $body = "Chapter Added- " . $chapter->name;
        $link = route('course.subject.chapter.index', [$course_id, $subject_id]);
        $users = $course->users;
        $this->create_notification($title, $body, $link, $users, 0);
        
        return redirect()->route('course.subject.chapter.index', [$course_id, $subject_id])->with('message','Chapter Successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
