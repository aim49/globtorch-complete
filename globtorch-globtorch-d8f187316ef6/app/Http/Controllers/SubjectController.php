<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Subject;
use App\User;
use App\Course;

class SubjectController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $course = Course::find($id);
        return view('subject.create', compact('course'));
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
            'name'=>'required',
            'course_id' => 'required',
            'order' => 'required'
        ]);

        //getting the course that the subject should belong to
        $course = Course::find($request->input('course_id'));
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
        $subject->course_id = $request->input('course_id');
        $subject->order = $order;
        $subject->save();
        return redirect('/subject/create/' . $subject->course->id)->with('message','Subject Successfully added');
    }

    //view subjects
    public function view_subjects(){
        $subjects = Subject::all();
        return view('admin.view_subject',compact('subjects'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject = Subject::find($id);
        return view('subject.show')->with('subject', $subject);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = Subject::find($id);
        return view('subject.edit',compact('subject'));
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
            'name'=>'required',
            'order' => 'required'
            ]);
            
       $subject_update = Subject::find($id);

       //getting the course that the subject should belong to
       $course = Course::find($subject_update->course_id);
       $order = $request->input('order');
       $subjects = $course->subjects->sortBy('order');

       //checking if the order is within acceptable boundaries
       if ($order < 1)
       {
            $order = 1;
       }
       else if($order > $subjects->last()->order)
       {
            $order = $subjects->last()->order;
       }

       if (count($course->subjects) > 0)
       {
            foreach($subjects as $subject)
            {
                if ($order > $subject_update->order)
                {
                    if ($subject->order >= $subject_update->order && $subject->order <= $order)
                    {
                        $subject->order--;
                    }
                }
                else if ($order < $subject_update->order)
                {
                    if ($subject->order >= $order && $subject->order <= $subject_update->order)
                    { 
                        $subject->order++;
                    }
                }
                else
                {
                    break;
                }
                $subject->save();
            }
       }

       $subject_update->name = $request->name;
       $subject_update->order = $order;
       $subject_update->save();
       return redirect('/subject/create/' . $subject_update->course->id)->with('message','Subject Successfully added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);
        $subject->delete();

        return redirect()->route('view_subjects')->with('message','Subject successfully deleted');
    }
}
