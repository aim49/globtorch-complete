<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Course;
use App\Enrollment;

class EnrollmentController extends Controller
{
    /**
     * Display all the courses that belong to a student
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //getting all the courses that the student is enrolled on
        $student = User::find(Auth::id());
        $enrollments = Enrollment::with('payments')->with('course')->where('user_id', $student->id)->get();

        //getting all other courses that the student isn't already enrolled on
        $enrolled_course_ids = Enrollment::where('user_id', $student->id)->select('course_id')->get();    
        $courses = Course::whereNotIn('id', $enrolled_course_ids)->get();

        return view('enrollment.index', compact('enrollments', 'courses'));
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
        //
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
