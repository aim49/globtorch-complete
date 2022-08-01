<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exam_Board;
use Validator;
class Exam_BoardController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $exam_boards = Exam_Board::all();   
        return view('exam_board.index', compact('exam_boards'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        return view('exam_board.create');
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
        $exam_board = new Exam_Board;
        $exam_board->name=$request->name;
        $exam_board->description=$request->description;
        $exam_board->save();
        $exam_board = Exam_Board::all();   
        return redirect('/exam_board');
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
        $exam_boards = Exam_Board::find($id);   

        return view('exam_board.edit', compact('exam_boards'));
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
        $exam_boards = Exam_Board::find($id);  
        $input = request(['name','description']);
        $exam_boards->fill($input)->save();
        return redirect('/exam_board');
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
        $exam_boards = Exam_Board::find($id);  
        $exam_boards->delete();
        return redirect('/exam_board');
    }
}

