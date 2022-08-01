<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Topic;
use App\Content;
use App\Chapter;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if ($this->hasActiveSubscription($id) == 0)
        {
            return response()->json([
                'message' => 'User has not paid for this course',
                'errors' => ['error' => 'You do not have an active subscription']
            ], 401);
        }
        $topic = Topic::with('contents')->findOrFail($id);
        $chapter = Chapter::findOrFail($topic->chapter_id);
        if ($this->hasDoneTest($chapter) == 0)
        {
            return response()->json([
                'message' => 'Previous chapter not complete',
                'errors' => ['error' => 'You cannot move to the next chapter without completing the previous chapter test']
            ], 401);
        }
        $texts = $this->getTextContent($topic->contents);

        return response()->json(
            ['slides' => $texts,
             'topic' => $topic
            ], 200);
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

    public function hasActiveSubscription($topic_id)
    {
        if (Auth::user()->user_type == "student")
        {
            $today = date('Y-m-d');
            $subscriptions = User::join('enrollments', 'users.id', '=' , 'enrollments.user_id')
                ->join('payments', 'enrollments.id', '=', 'payments.enrollment_id')
                ->join('courses', 'courses.id', '=', 'enrollments.course_id')
                ->join('course_subject', 'course_subject.course_id', 'courses.id')
                ->join('subjects', 'course_subject.subject_id', '=', 'subjects.id')
                ->join('chapters', 'subjects.id', '=', 'chapters.subject_id')
                ->join('topics', 'chapters.id', '=', 'topics.chapter_id')
                ->select('payments.*')
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->where('topics.id', '=', $topic_id)
                ->where('users.id', '=', Auth::user()->id)
                ->orderBy('end_date')->get();

            if (count($subscriptions) == 0)
            {
                return 0;
            }
        }
        return 1;
    }

    public function hasDoneTest($chapter)
    {
        if ($chapter->order > 1)
        {
            $results = Chapter::join('chapter_results', 'chapters.id', '=' , 'chapter_results.chapter_id')
                ->select('chapter_results.*')
                ->where([
                    ['order', '=', $chapter->order - 1],
                    ['subject_id', '=', $chapter->subject_id]
                    ])
                ->get()->first();
            $previous_chapter = Chapter::where([
                    ['order', '=', $chapter->order - 1],
                    ['subject_id', '=', $chapter->subject_id]
                ])->get()->first();

            if (Auth::user()->user_type == 'student' && count($previous_chapter->questions) > 0)
            {
                if ($results == null || $results->percentage < 50)
                {
                    return 0;
                }
            }
        }
        return 1;
    }

    public function getTextContent($contents)
    {
        $texts = array();
        if (count($contents) > 0)
        {
            $contents = $contents->sortby('order')->values()->all();
            foreach($contents as $content)
            {
                if ($content->type == 'text')
                {
                    $path = 'public/content/'.$content->path;
                    $text_from_file = Storage::get($path);
                    array_push($texts, array($content->id, $text_from_file));
                }
            }
        } 
        return $texts;
    }
}
