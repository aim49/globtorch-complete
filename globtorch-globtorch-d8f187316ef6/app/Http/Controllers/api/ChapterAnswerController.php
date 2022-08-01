<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\ChapterAnswer;
use App\ChapterQuestion;
use App\ChapterResult;
use App\MessageLog;
use App\Chapter;

class ChapterAnswerController extends Controller
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
    public function create($id)
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
                ->where('chapters.id', '=', $id)
                ->where('users.id', '=', Auth::user()->id)
                ->orderBy('end_date')->get();

            if (count($subscriptions) == 0)
            {
                return response()->json([
                    'errors' => 'You do not have an active subscription'
                ], 401);
            }
        }

        $chapter = Chapter::with('questions')->find($id);
        return response()->json(
            ['chapter' => $chapter
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $number_of_records = $request->input('number_of_records');
        $score = 0;

        for ($i=0; $i < $number_of_records; $i++) 
        { 
            $question_id = $request->input($i);
            $question_answer = $request->input($question_id . 'answer');
            $question = ChapterQuestion::findOrFail($question_id);

            if ($question->answer == $question_answer)
            {
                $isCorrect = true;
                $score++;
            }
            else
            {
                $isCorrect = false;
            }

            $answer = ChapterAnswer::where([
                ['chapter_question_id', $question_id],
                ['user_id', Auth::user()->id]
            ])->get();

            if (count($answer)>0)
            {
                $answer = $answer[0];
            }
            else
            {
                $answer = new ChapterAnswer;
            }
            $answer->answer = $question_answer;
            $answer->isCorrect = $isCorrect;
            $answer->chapter_question_id = $question_id;
            $answer->user_id = Auth::user()->id;
            $answer->save();
        }

        //recording overall results
        $result = ChapterResult::where([
            ['chapter_id', $question->chapter_id],
            ['user_id', Auth::user()->id]
        ])->get();

        if (count($result) > 0)
        {
            $result = $result[0];
        }
        else
        {
            $result = new ChapterResult;
        }
        $result->score = $score;
        $result->total = $number_of_records;
        $result->percentage = (int)($score * 100/$number_of_records);
        $result->chapter_id = $question->chapter_id;
        $result->user_id = Auth::user()->id;
        $result->save();

        return response()->json(['message'=>'Successfully saved answers'], 200);
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
