<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class PasswordController extends Controller
{
    public function change()
    {
        return view('user.password_change');
    }

    public function set(Request $request)
    {
        $this->validate($request,[
            'current_password'=>'required',
            'new_password'=>'required',
            'verify_password'=>'required'
        ]);

        if(Auth::attempt([
            'school_id' =>Auth::user()->school_id,
            'password'=>request('current_password'),
            'isEnabled'=>1
            ]))
        {
            $password = $request->input('new_password');
            if ($password == $request->input('verify_password'))
            {
                $user = User::find(Auth::user()->id);
                $user->password = bcrypt($password);
                $user->save();
                return back()->with('message', 'Password successfully changed');
            }
            else
            {
                return redirect('password/change')->withErrors('Passwords do not match');
            }
        }
        else
        {
            return redirect('password/change')->withErrors('Current password is incorrect, please try again');
        }
    }

    // admin to reset passwords
    public function getPasswordReset($user_id)
    {
        $user = User::find($user_id);
        return view('admin.password.reset', compact('user'));
    }

    public function storePasswordReset(Request $request, $user_id)
    {
        $request->validate(['password' => 'string|confirmed']);

        $user = User::find($user_id);
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->route('student.index')->with('message', 'Successfully changed password');
    }
}
