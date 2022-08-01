<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Course;
use App\Chapter;

class CourseResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $results = Course::join('course_subject', 'course_subject.course_id', 'courses.id')
            ->join('subjects', 'subjects.id', 'course_subject.subject_id')
            ->join('chapters', 'chapters.subject_id', 'subjects.id')
            ->join('chapter_results', 'chapter_results.chapter_id', 'chapters.id')
            ->select('chapters.id as chapterId', 'courses.name as courseName', 'subjects.name as subjectName', 'chapters.name as chapterName', 'percentage')
            ->where('chapter_results.user_id', Auth::id())
            ->where('courses.id', $course_id)
            ->get();

        $chapters = Chapter::join('subjects', 'subjects.id', 'chapters.subject_id')
            ->join('course_subject', 'course_subject.subject_id', 'subjects.id')
            ->join('courses', 'course_subject.course_id', 'courses.id')
            ->select('subjects.name as subjectName', 'chapters.*')
            ->withCount('questions')
            ->where('courses.id', $course_id)
            ->get();
        $chapters = $chapters->where('questions_count', '>', 0);
        return response()->json(['results' => $results, 'chapters'=>$chapters]);
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
