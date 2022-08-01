<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Course_Board;
use App\Exam_Board;
use App\Exam;
class Course_BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //viewing course boards
        $course_boards = Course_Board::all();
        return view('course_board.index', compact('course_boards'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //viewing a lot of shit
        $course_boards = Course_Board::all();
        $courses = Course::all();
        $exam_boards = Exam_Board::all();
        return view('course_board.create', compact('course_boards','courses','exam_boards'));
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
        $course_board=new course_board();
        $course_board->course_id=$request->course_id;
        $course_board->board_id=$request->board_id;
        $course_board->exam_months=$request->exam_months;
        $course_board->exam_price=$request->exam_price;
        $course_board->save();
        $course_boards = Course_Board::all();
        return redirect('/course_board');
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
        $course_boards = Course_Board::find($id);
        $courses = Course::all();
        $exam_boards = Exam_Board::all();
        return view('course_board.edit', compact('course_boards','courses','exam_boards'));
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
        // update a course
        $course_boards = Course_Board::find($id);
        $input = request(['course_id','board_id', 'exam_months', 'exam_price']);
        $course_boards->fill($input)->save();
        return redirect('/course_board');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete a course
        $course_boards = Course_Board::find($id);
        $course_boards->delete();
        return redirect('/course_board');
    }
}

