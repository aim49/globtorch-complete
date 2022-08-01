<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Subject;
use App\Course;
use App\Course_Board;
use App\Exam_Board;
use Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = Course::all();
        return view('course.index', compact('courses'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exams = Exam_Board::all()->pluck('name', 'id');
        return view('course.create',compact('exams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $has_image = 0;
        if ($request->hasFile('image'))
        {
            $full_file_name = $request->file('image')->getClientOriginalName();
            $name = pathinfo($full_file_name, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $file_name_to_store = $name.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/course', $file_name_to_store);
            $has_image = 1;
        }
        else
        {
            $file_name_to_store = 'course.jpg';
        }

        //saving the course
        $course = new course();
        $course->code = $request->code;
        $course->name = $request->name;
        $course->description = $request->description;
        $course->duration = $request->duration;
        $course->level = $request->level;
        $course->price = $request->price;
        $course->image = $file_name_to_store;
        $course->save();

        //saving the course_board (exam board for the course)
        $course_board = new Course_Board();
        $course_board->course_id = $course->id;
        $course_board->board_id = $request->exam_board;
        $course_board->exam_months = $request->exam_months;
        $course_board->exam_price = $request->exam_price;
        $course_board->save();

        return redirect('/course')->with('message','Course successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);

        return view('course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course_detail=Course::find($id);
        $exams=DB::table('exam_boards')->get();    

        return view('course.edit',compact('course_detail','exams'));
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
        $course = Course::find($id);
        $course->name=$request->name;
        $course->description=$request->description;
        $course->duration = $request->duration;
        $exam_board_id = $request->input('exam_board');
        $is_board_found = 0;
        foreach($course->exam_boards as $exam_board)
        {
            if ($exam_board == $exam_board_id)
            {
                $is_board_found = 1;
                $exam_board->pivot->exam_months = $request->input('exam_months');
                $exam_board->pivot->exam_price = $request->input('exam_price');
                $exam_board->pivot->save();
            }
        }
        if ($is_board_found == 0)
        {
            $course->exam_boards()->detach();
            $course->exam_boards()->attach($exam_board_id, ['exam_months' => $request->input('exam_months'), 'exam_price' => $request->input('exam_price')]);
        }
        $course->level=$request->level;
        $course->price=$request->price;
        $course->save();
        
        return redirect('/course')->with('message','Course successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courses = Course::find($id);
        $courses->delete();
        return redirect('/course')->with('message','Course successfully deleted');
    }

    public function search(Request $request)
    {
        $course_code = $request->input('course_code');
        $course = Course::where('code', $course_code)->get()->first();
        return $course;
    }

    public function report()
    {
        $courses = Auth::user()->courses;
        return view('course.report.index', compact('courses'));
    }

    public function show_report($id)
    {
        $course = Course::with('subjects')->find($id);
        return view('course.report.show', compact('course'));
    }

    public function resources()
    {
        return view('course.resource.index');
    }
}
