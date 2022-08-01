<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\ChapterQuestion;
use App\Chapter;
use App\TeacherActivity;

class ChapterQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $chapter = Chapter::find($id);
        return view('chapter.question.index', compact('chapter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $chapter = Chapter::find($id);
        return view('chapter.question.create', compact('chapter'));
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
            'question'=>'required',
            'a' => 'required',
            'b'=>'required',
            'c' => 'required',
            'd' => 'required',
            'answer' => 'required',
            'id' => 'required'
            ]);

        $question = new ChapterQuestion;
        $question->question = $request->input('question');
        $question->answer_a = $request->input('a');
        $question->answer_b = $request->input('b');
        $question->answer_c = $request->input('c');
        $question->answer_d = $request->input('d');
        $question->answer = $request->input($request->input('answer'));
        $question->chapter_id = $request->input('id');
        $question->save();

        //logging the teacher activity
        if (Auth::user()->user_type == 'teacher')
        {
            $activity = new TeacherActivity;
            $activity->log = 'Created test questions';
            $activity->url = '/chapter_question/' . $question->chapter_id;
            $activity->user_id = Auth::id();
            $activity->save();
        }

        return redirect('/chapter_question/' . $question->chapter_id)->with('message', 'Successfully added question: ' . $question->question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
            ]);
        $question = ChapterQuestion::find($request->input('id'));
        return view('chapter.question.edit', compact('question'));
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
            'question'=>'required',
            'a' => 'required',
            'b'=>'required',
            'c' => 'required',
            'd' => 'required',
            'answer' => 'required',
            ]);

        $question = ChapterQuestion::find($id);
        $question->question = $request->input('question');
        $question->answer_a = $request->input('a');
        $question->answer_b = $request->input('b');
        $question->answer_c = $request->input('c');
        $question->answer_d = $request->input('d');
        $question->answer = $request->input($request->input('answer'));
        $question->save();

        //logging the teacher activity
        if (Auth::user()->user_type == 'teacher')
        {
            $activity = new TeacherActivity;
            $activity->log = 'Updated test questions';
            $activity->url = '/chapter_question/' . $question->chapter_id;
            $activity->user_id = Auth::id();
            $activity->save();
        }

        return redirect('/chapter_question/' . $question->chapter_id);
    }
}
