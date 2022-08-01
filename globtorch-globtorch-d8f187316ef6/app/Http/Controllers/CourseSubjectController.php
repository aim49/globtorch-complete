<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Subject;
use App\Course;

class CourseSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $course = Course::with('subjects')->find($course_id);
        return view('course.subject.index', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        $course = Course::with('subjects')->findOrFail($course_id);
        return view('course.subject.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $course_id)
    {
        $this->validate($request,[
            'name'=>'required',
            'order' => 'required'
        ]);

        //getting the course that the subject should belong to
        $course = Course::with('subjects')->findOrFail($course_id);
        $order = $request->input('order');

        if (count($course->subjects) > 0)
        {
            $subjects = $course->subjects->sortBy('order');

            // if user id trying to put the order outside the limit, reset to max
            if ($order < 1 || $order > ($subjects->last()->order + 1))
            {
                $order = $subjects->last()->order + 1;
            }

            // the order is supposed to replace an existing one, shift records up
            if (($subjects->last()->order + 1) != $order)
            {
                foreach($subjects as $subject)
                {
                    if ($subject->order >= $order)
                    {
                        $subject->order++;
                        $subject->save();
                    }
                }
            }
        }

        $subject = new Subject;
        $subject->name = $request->name;
        $subject->course_id = $course_id;
        $subject->order = $order;
        $subject->save();
        $subject->courses()->attach($course_id);
        return redirect()->route('course.subject.create', $course->id)->with('message','Subject Successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_id, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $id)
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
    public function update(Request $request, $course_id, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id, $id)
    {
        $course = Course::findOrFail($course_id);
        $course->subjects()->detach($id);
        return redirect()->route('course.subject.create', $course_id)->with('message', 'Successfully removed subject from course');
    }

    public function addExistingSubject($course_id)
    {
        $course = Course::with('subjects')->findOrFail($course_id);
        $otherCourses = Course::with('subjects')->where('id', '<>', $course_id)
            ->orderBy('name')
            ->get();
        $existing_subject_ids = $course->subjects->pluck('id')->toArray();
        return view('course.subject.add', compact('course', 'otherCourses', 'existing_subject_ids'));
    }

    public function storeExistingSubject(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);
        $subjects = Subject::all();
        foreach($subjects as $subject)
        {
            if ($request->has($subject->id))
            {
                $course->subjects()->syncWithoutDetaching($subject->id);
            }
        }
        return redirect()->route('course.subject.add', $course_id)->with('message', 'Successfully added subjects');
    }
}
