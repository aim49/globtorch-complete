<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\User;

class UserController extends Controller
{
    public function courses()
    {
        $user = User::with('courses')->findOrFail(Auth::id());
        $courses = $user->courses;
        return response()->json($courses, 200);
    }
}
