<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\TeacherActivity;
use App\User;

class TeacherActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teacher_activities = TeacherActivity::orderBy('id', 'desc')->get();
        return view('teacher.activity.index', compact('teacher_activities'));
    }

    public function show($teacher_id)
    {
        $teacher = User::with('teacher_activities')->find($teacher_id);
        return view('teacher.activity.single', compact('teacher'));
    }
}
