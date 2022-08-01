<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Discussion;
use App\Comment;
use App\Enrollment;
use App\Course;
use App\Institution;
use App\MessageLog;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\StudentAdded;

use App\Traits\UserTrait;
use App\Traits\MessageTrait;
use App\Traits\CountryTrait;

class StudentController extends Controller
{
    use UserTrait;
    use MessageTrait;
    use CountryTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students=User::where([
                ['user_type', 'student']
            ])
            ->orderBy('surname')
            ->orderBy('name')
            ->paginate(100);
        return view('student.index',compact('students'));
    }

    public function search(Request $request)
    {
        $students = User::where([
            ['name', 'like', '%' . $request->input('name') . '%'],
            ['surname', 'like', '%' . $request->input('surname') . '%'],
            ['school_id', 'like', '%' . $request->input('user_id') . '%'],
        ])->paginate(100);
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->get_countries();
        $institutions = Institution::orderBy('name')->pluck('name', 'id');
        return view('student.create', compact('countries', 'institutions'));
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
            'name'=>'string|max:255|required',
            'surname'=>'string|max:255|required',
            'gender'=>'string|nullable',
            'address'=>'string|max:255|nullable',
            'dob'=>'nullable',
            'city'=>'string|max:255|nullable',
            'country'=>'string|max:255|required',
            'phone'=>'string|max:255|required',
            'email'=>'email|nullable',
            'institution_id' => 'integer|nullable'
        ]);
        
        //generate a random password
        $password = substr(sha1(mt_rand()),6,6);

        $email = $request->input('email');
        $phone = $request->input('phone');
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
        
        if (count($users) > 0)
        {
            return back()->withErrors('User with that email or phone number already exists!');
        }

        $user = new User();
        $user->name = request('name');
        $user->surname = request('surname');
        $user->dob = request('dob');
        $user->address = request('address');
        $user->city = request('city');
        $user->country = request('country');
        $user->phone = $phone;
        $user->email = $email;
        $user->gender = request('gender');
        $user->user_type = 'student';
        $user->school_id = $this->get_user_id('student');
        $user->password = bcrypt($password);
        $user->institution_id = $request->input('institution_id');
        $user->save();

        if ($user->country == 'Zimbabwe')
        {
            $message = "Thank you for choosing Globtorch\nUser ID = " . $user->school_id . "\nPassword = " . $password . "\nLogin at www.globtorch.com\nPlease change your password on login.";
            $this->send_message($user->phone, $message);
            $messageLog = new MessageLog;
            $messageLog->purpose = 'admin registered student';
            $messageLog->number = 1;
            $messageLog->save();
        }

        if(filter_var($user->email, FILTER_VALIDATE_EMAIL ))
        {
            Mail::to($user->email)->send(new StudentAdded($user->school_id, $password));
        }
        return redirect('student/create')->with('message','Student ' . $user->name . ' ' . $user->surname . ' successfully added');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->courses()->detach();
        $user->delete();
        return redirect()->route('student.index')->with('message', 'Successfully deleted user');
    }
    
    //login page
    public function login()
    {
        return view('student.login');
    }

    //registration page
    public function register()
    {
        $countries = $this->get_countries();
        $institutions = Institution::orderBy('name')->pluck('name', 'id');
        return view('student.register', compact('institutions', 'countries'));
    }

    //viewing paid students
    public function view_paid_students()
    {
        $students = Enrollment::join('users', 'users.id', '=' , 'enrollments.user_id')
            ->join('payments', 'enrollments.id', '=', 'payments.enrollment_id')
            ->select('surname', 'name', 'school_id', 'phone', 'email', 'country', 'date', 'method', 'amount', 'course_id')
            //->whereMonth('date', '=', Carbon::today()->month)
            //->orderBy('name')->get();
            ->orderBy('date', 'desc')->get();
        return view('student.paid',compact('students'));
    }

    public function get_course()
    {
        $courses = Course::orderBy('name')->get();
        return view('student.view.course', compact('courses'));
    }

    public function by_course($course_id)
    {
        $course = Course::find($course_id);
        $today = date('Y-m-d');
        $students = User::join('enrollments', 'users.id', '=' , 'enrollments.user_id')
            ->join('payments', 'enrollments.id', '=', 'payments.enrollment_id')
            ->join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->select('users.*')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('courses.id', '=', $course_id)
            ->get();

        return view('student.view.by_course', compact('course', 'students'));
    }

    public function teachers()
    {
        $user_ids = User::join('enrollments', 'users.id', '=' , 'enrollments.user_id')
            ->join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->join('subjects', 'subjects.course_id', '=', 'courses.id')
            ->join('teacher_subjects', 'teacher_subjects.subject_id', 'subjects.id')
            ->select('teacher_subjects.user_id')
            ->where('users.id', Auth::id())
            ->distinct()->get();

        $teachers = User::whereIn('id', $user_ids)->get();

        $subject_ids = User::join('enrollments', 'users.id', '=' , 'enrollments.user_id')
            ->join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->join('subjects', 'subjects.course_id', '=', 'courses.id')
            ->select('subjects.id')
            ->where('users.id', Auth::id())
            ->get()->pluck('id');

        //return $teachers->first()->subjects->whereIn('id', $subject_ids)->sortBy('course_id');

        return view('student.teacher.index', compact('teachers', 'subject_ids'));
    }

    public function print()
    {
        $students=User::where([
            ['user_type', 'student']
        ])
        ->orderBy('surname')
        ->orderBy('name')
        ->get();
        return view('student.print',compact('students'));
    }
}
