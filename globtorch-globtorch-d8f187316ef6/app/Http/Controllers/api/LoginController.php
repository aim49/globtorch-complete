<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\LoginHistory;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request,[
            'school_id'=>'required',
            'password'=>'required'
        ]);

        $type = 'school_id';
        $school_id = $request->input('school_id');
        $password = $request->input('password');
        $remember = 0;
        if (filter_var($school_id, FILTER_VALIDATE_EMAIL)) 
        {
            $type = 'email';
        }
        elseif(is_numeric($school_id))
        {
            $type = 'phone';
        }

        if(Auth::attempt([$type => $school_id, 'password' => $password], $remember))
        {
            $login_history = new LoginHistory;
            $login_history->user_id = Auth::user()->id;
            $login_history->save();
            Auth::user()->generateToken();
            return response()->json(['data' => Auth::user()->toArray()], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Incorrect login details',
                'errors' => ['login' => 'Please check your username and password']
            ], 400);
        }
    }
}
