<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Course_Board;
use App\Exam_Board;
use App\Subject;
use App\Newsletter;
use App\Directory;

use Carbon\Carbon;
use App\Notifications\UserNotifications;
use App\User;
use App\LoginHistory;

use Validator;
class WelcomeController extends Controller
{
    public function index()
    {
        $courses = Course::inRandomOrder()
            ->take(3)->get();
        return view('welcome',compact('courses'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function courses()
    {
        $courses = Course::paginate(12);
        return view('courses',compact('courses'));
    }
    public function course_details($id)
    {
        $courses = Course::find($id);
        $subjects = Subject::where('course_id',$id)->get();
        return view('course_details',compact('courses','subjects'));
    }
    public function news()
    {
        return view('news');
    }
    public function news_post()
    {
        return view('news_post');
    }
    public function directories()
    {
        $directories = Directory::orderBy('name')->get();
        return view('directory', compact('directories'));
    }
    public function primary()
    {
        return view('primary');
    }
    public function about()
    {
        return view('about');
    }

    public function search(Request $request)
    {
        $courses = Course::where([
            ['level', $request->input('level')], 
            ['name', 'like', '%'.$request->input('keyword').'%']
        ])->paginate(9);
        return view('courses', compact('courses'));
    }

    public function newsletter(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email'
            ]);

        $email = $request->input('email');
        $newsletter_exists = Newsletter::where('email', $email)->get();
        
        if (count($newsletter_exists) == 0)
        {
            $newsletter = new Newsletter;
            $newsletter->email = $request->input('email');
            $newsletter->save();
            return response()->json(['message'=>'Successfully signed up!']);
        }
        else
        {
            return response()->json(['message'=>'You have already signed up!']);
        }
    }

    public function notify()
    {
        $limit = Carbon::now()->subDay(7);
        //$users = User::where('last_activity', '<', $limit)->get();
        //$users = User::where('last_activity', null)->get();
        //$users = LoginHistory::select('user_id')->distinct()->get();

        $subject = 'Login reminder';
        $introduction = 'You have not logged in for a while';
        $notification_action = 'Login';
        $notification_url = route('login');
        $conclusion = 'Thank you for studying with us';
        $users = User::where('school_id', 'GS0001')->get();
        foreach($users as $user)
        {
            $user->notify(new UserNotifications($subject, $introduction, $notification_action, $notification_url, $conclusion));
        }
        return ;
    }
}
