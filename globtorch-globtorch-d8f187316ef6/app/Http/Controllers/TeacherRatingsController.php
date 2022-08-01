<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\User;
use App\TeacherRating;

class TeacherRatingsController extends Controller
{
    public function index($teacher_id)
    {
        $teacher = User::find($teacher_id);

        return view('teacher.rating.index', compact('teacher'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($teacher_id)
    {
        $teacher = User::where([
            ['id', $teacher_id],
            ['user_type', 'teacher']
            ])->get()->first();

        if ($teacher == null)
        {
            return back()->withErrors('Cannot find teacher');
        }

        $rating = $teacher->teacher_ratings->where('student_id', Auth::id())->first();
        if ($rating != null)
        {
            return view('teacher.rating.edit', compact('teacher', 'rating'));
        }

        return view('teacher.rating.create', compact('teacher'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'score' => 'integer|required',
            'comment' => 'string|required|max:255'
        ]);

        $rating = new TeacherRating;
        $rating->score = $request->input('score');
        $rating->comment = $request->input('comment');
        $rating->teacher_id = $request->input('teacher_id');
        $rating->student_id = Auth::id();
        $rating->save();

        return redirect()->route('student.teachers')->with('message', 'Successfully submitted teacher rating');
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
        $request->validate([
            'score' => 'integer|required',
            'comment' => 'string|required|max:255'
        ]);

        $rating = TeacherRating::find($id);
        $rating->score = $request->input('score');
        $rating->comment = $request->input('comment');
        $rating->save();

        return redirect()->route('student.teachers')->with('message', 'Successfully submitted teacher rating');
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
