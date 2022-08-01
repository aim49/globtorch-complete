<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Payment;
use App\Course;
use App\LoginHistory;
use App\Enrollment;
use App\Note;
use App\MessageLog;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;
use App\Mail\PasswordReset;

use App\Traits\UserTrait;
use App\Traits\MessageTrait;
use App\Traits\CountryTrait;

class UserController extends Controller
{
    use UserTrait;
    use MessageTrait;
    use CountryTrait;
    
    /*
    *   function used when attempting to login
    */
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

        //trying to login which evaluates to a boolean
        if(Auth::attempt([$type => $school_id, 'password' => $password], $remember))
        {
            $login_history = new LoginHistory;
            $login_history->user_id = Auth::user()->id;
            $login_history->save();
            return redirect()->route('home')->with('message','Succssfully logged in');
        }
        else
        {
            return redirect()->route('login')->withErrors('incorrect login details');
        }
    }

    /*
    *   function used when logging out
    */
    public function logout()
    {
        Auth::logout();
        session()->flush();

        return redirect()->route('login');
    }

    /**
     * Function used when registering a student
     */
    public function register(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'surname'=>'required',
            'phone'=>'required',
            'email'=>'email|nullable',
            'country' => 'required',
            'password'=>'required',
            'institution_id' => 'integer|nullable'
        ]);

        try
        {
            $surname = $request->input('surname');
            $name = $request->input('name');
            $phone = $request->input('phone');
            $email = $request->input('email');
            if ($email != null && $phone != null)
            {
                $users = User::where('email', $email)
                    ->orWhere('phone', $phone)
                    ->get();
            }
            else if ($email == null && $phone != null)
            {
                $users = User::where('phone', $phone)->get();
            }
            else if ($email != null && $phone == null)
            {
                $users = User::where('email', $email)->get();
            }
            if (count($users) == 0)
            {
                session(['name' => $request->input('name'),
                        'surname' => $request->input('surname'),
                        'phone' => $request->input('phone'),
                        'email' => $request->input('email'),
                        'country' => $request->input('country'),
                        'institution_id' => $request->input('institution_id'),
                        'password' => bcrypt($request->input('password')),
                        'referral' => $request->input('referral')
                ]);
            }
            else
            {
                return back()->withErrors('Email or Phone number already in use! Use password recovery if you forgot your password.');
            }
        }
        catch(Exception $e)
        {
            return ('An error has occured: ' . $e);
        }

        $courses = Course::orderBy('name')->get();
        return view('student.register_course', compact('courses'));
    }

    public function registration_course($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('payments.registration', compact('course'));
    }
    
    /** PASSWORD RESET SECTION */
    
    /**
     * User has requested to reset password
     * Direct them to the place to select their password reset options
     */
    public function init_password_reset()
    {
        return view('user.password_reset');
    }

    /**
     * Checking the user ID and sending a password reset code to the user's choice
     * SMS only works in Zimbabwe whereas email is global
     */
    public function submitted_password_reset(Request $request)
    {
        $this->validate($request, [
            'user_id'=>'required',
            'option'=>'required'
        ]);

        $user_id = $request->input('user_id');
        $code = substr(sha1(mt_rand()),6,6);
        session()->put('user_id',$user_id);
        session()->put('reset_attempts', 0);
        session()->put('code',$code);

        $user = User::where('school_id', $user_id)->get()->first();
        if ($user != null)
        {
            if ($request->input('option') == 'phone')
            {
                if ($user->country == 'Zimbabwe')
                {
                    $message = "Your password reset code is: " . $code;
                    $this->send_message($user->phone, $message);
                    $messageLog = new MessageLog;
                    $messageLog->purpose = 'password reset code';
                    $messageLog->number = 1;
                    $messageLog->save();
                }
                else
                {
                    return back()->withErrors('Cannot send messages in your country. Only Zimbabwe supported');
                }
            }
            else if ($request->input('option') == 'email')
            {
                if(filter_var($user->email, FILTER_VALIDATE_EMAIL ))
                {
                    Mail::to($user->email)->send(new PasswordReset($code));
                }
                else
                {
                    return back()->withErrors('Email address on this account is not in the right format');
                }
            }
            else
            {
                return back()->withErrors('password reset option not detected');
            }
        }
        else
        {
            return back()->withErrors('User ID not found');
        }
        return view('user.password_reset_code');
    }

    /**
     * Confirming the password reset code and the passwords
     * Changing the password if all validation checks are there
     */
    public function accept_password_reset(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'password' => 'required',
            'password_confirm' => 'required'
        ]);

        session()->put('reset_attempts', session()->get('reset_attempts') + 1);
        if (session()->get('reset_attempts') <= 3)
        {
            if ($request->input('code') == session()->get('code'))
            {
                $password = $request->input('password');
                if ($password == $request->input('password_confirm'))
                {
                    $user = User::where('school_id', session()->get('user_id'))->get()->first();
                    $user->password = bcrypt($password);
                    $user->save();
                    return redirect('/signin')->with('message', 'Password successfully reset');
                }
                else
                {
                    if (session()->get('reset_attempts') < 3)
                    {
                        return view('user.password_reset_code')->withErrors('Passwords do not match. ' . (3 - session()->get('reset_attempts')) . ' attempts remaining.');
                    }
                }
            }
            else
            {
                if (session()->get('reset_attempts') < 3)
                {
                    return view('user.password_reset_code')->withErrors('Password reset code not found! ' . (3 - session()->get('reset_attempts')) . ' attempts remaining.');
                }
            }
        }
            
        return redirect('/password_reset')->withErrors('You have failed to reset your password 3 times, please try again!');
    }

    /** END PASSWORD RESET */

    /**
     * getting confirmation page
     */
    public function get_confirm_page()
    {
        return view('student.confirm');
    }

    /**
     * confirming the registrant code was received
     */
    public function confirm_register(Request $request)
    {
        $this->validate($request,[
            'code'=>'required'
        ]);

        $code=request('code');
        $school_id=session()->get('school_id');
        if($school_id==$code)
        {
            $user = User::where('school_id', $school_id)->get()->first();
            $user->isEnabled = 1;
            $user->save();

            return redirect()->route('login')->with('message','You have successfully registered');
        }
        else
        {
            return redirect()->route('register')->withErrors('wrong school id, please try again');
        }
    }

    /**
     * Function to get the home page
     * calls function according to the user_type
     */
    public function home()
    {
        if (Auth::user()->user_type == 'admin')
        {
            return ($this->admin_home());
        }
        else if(Auth::user()->user_type == 'teacher')
        {
            return($this->teacher_home());
        }
        else if (Auth::user()->user_type == 'student')
        {
            return($this->student_home());
        }
        else
        {
            return view('/')->withErrors('user type not found!');
        }
    }

    /**
     * Load the admin home page
     */
    private function admin_home()
    {
        $today = date('Y-m-d');

        $num_students = $this->get_num_students();
        $num_teachers = $this->get_num_teachers();
        $num_active_students = count(
            User::where([ 
                ['user_type', 'student'],
                ['last_activity', '>=', date('Y-m-d', strtotime('-3 days', strtotime($today)))]
            ])->get()
            );
        $payments = Payment::where([
            ['method', '<>' , 'free'],
            ['date', '>=', '2020-01-01']
        ]
        )->sum('amount');
        $login_histories = $this->get_login_history();
        $notes = $this->get_notes();
        $num_claimed_promotions = count(Payment::where([
            ['method', 'Free'],
            ['end_date', '2019-12-31']
            ])->get());

        return view('admin.home', compact(['num_claimed_promotions', 'num_students', 'num_teachers', 'num_active_students', 'payments', 'login_histories', 'notes']));
    }

    /**
     * Load the teacher home page
     */
    private function teacher_home()
    {
        $num_subjects = count(Auth::user()->subjects);
        $num_online_students = $this->get_active_students();        
        $num_students = $this->get_num_students();
        $commission = $this->get_commission();
        $login_histories = $this->get_login_history();
        $notes = $this->get_notes();

        return view('teacher.home', compact('num_subjects', 'num_online_students', 'num_students', 'commission', 'login_histories', 'notes'));
    }

    /**
     * Load the student home page
     */
    private function student_home()
    {
        $login_histories = $this->get_login_history();
        $commission = $this->get_commission();
        $num_students = $this->get_num_students();
        $num_teachers = $this->get_num_teachers();
        $num_courses = count(Enrollment::where('user_id', Auth::user()->id)->select('course_id')->get());
        $notes = $this->get_notes();

        $courses = Auth::user()->courses;

        return view('student.home', compact('courses', 'login_histories', 'commission', 'num_students', 'num_courses', 'num_teachers', 'notes'));
    }

    /**
     * Helper functions for duplicate functions on home pages
     */

    public function get_num_teachers()
    {
        $num_teachers = count(User::where('user_type', 'teacher')
            ->where('isEnabled', '1')
            ->get());
        return $num_teachers;
    }

    public function get_num_students()
    {
        $num_students = count(User::where('user_type', 'student')
            ->where('isEnabled', '1')
            ->get());
        return $num_students;
    }

    public function get_commission()
    {
        $commission = User::join('commissions', 'commissions.user_id', 'users.id')
            ->where('isPaid', 0)
            ->where('user_id', Auth::user()->id)
            ->get()->sum('amount');
        return $commission;
    }

    public function get_login_history()
    {
        $login_histories = LoginHistory::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get()->take(5);
        return $login_histories;
    }

    public function get_active_students()
    {
        $date = new \DateTime;
        $date->modify('-5 minutes');
        $timestamp = $date->format('Y-m-d H:i:s');
        $num_online_students = count(DB::table('users')
            ->where('user_type','=','student')
            ->where('last_activity','>=',$timestamp)
            ->get());
        return $num_online_students;
    }

    public function get_notes()
    {
        $notes = Note::where('user_id', Auth::user()->id)
            ->orderBy('isDone')->get();
        return $notes;
    }

    //---------------------------------------------------------------------------------------------

    /**
     * User to edit their own profile
     */
    public function edit($id)
    {
        if (Auth::user()->id != $id && Auth::user()->user_type != 'admin')
        {
            return back()->withErrors('You can only edit your own profile');
        }
        $user = User::find($id);
        $countries = $this->get_countries();
        return view('user.edit', compact(['user', 'countries']));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'surname'=>'required',
            'country'=>'required',
            'phone'=>'required'
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->gender = $request->input('gender');
        $user->address = $request->input('address');
        $user->dob = $request->input('dob');
        $user->city = $request->input('city');
        $user->country = $request->input('country');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->save();
        return redirect('/user/' . $user->id . '/edit')->with('message', 'Profile updated');
    }

    public function search_user(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::where('school_id', $user_id)->get()->first();
        return $user;
    }
}   