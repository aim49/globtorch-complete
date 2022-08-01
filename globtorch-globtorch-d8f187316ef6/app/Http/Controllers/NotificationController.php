<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Notification;
use App\UserNotification;
use App\User;
use App\MessageLog;

use Carbon\Carbon;

use App\Traits\MessageTrait;

use Illuminate\Support\Facades\Mail;
use App\Mail\Announcement;

class NotificationController extends Controller
{
    use MessageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return the view, notifications will be added from the AppServiceProvider automatically
        return view('user.notification');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_notification = UserNotification::where([
                ['notification_id', $id],
                ['user_id', Auth::user()->id]
            ])->get()->first();
        $user_notification->isRead = 1;
        $user_notification->save();
        return redirect($user_notification->notification->link);
    }

    public function all_read()
    {
        UserNotification::where([
                ['user_id', Auth::user()->id],
                ['isRead', 0]
            ])->update(['isRead' => 1]);
            
        return redirect('/notification');
    }

    public function create_announcement()
    {
        return view('user.announcement');
    }

    public function send_announcement(Request $request)
    {
        $this->validate($request,[
            'to'=>'required',
            'message' => 'required|max:160',
        ]);

        $less_two_days = Carbon::now()->subDay(2);

        switch($request->input('to'))
        {
            case 'all_users':
                $users = User::all();
                break;
            case 'all_students':
                $users = User::where('user_type', 'student')->get();
                break;
            case 'paid_students':
                $users = User::join('enrollments', 'enrollments.user_id', '=', 'users.id')
                    ->select('users.*')
                    ->get();
                break;
            case 'teachers':
                $users = User::where('user_type', 'teacher')->get();
                break;
            case 'students_inactive':
                $users = User::where([
                    ['last_activity', '<', $less_two_days],
                    ['user_type', 'student']
                    ])->get();
                break;
            case 'teachers_inactive':
                $users = User::where([
                    ['last_activity', '<', $less_two_days],
                    ['user_type', 'teacher']
                    ])->get();
                break;
            case 'never_logged_in':
                $users = User::where('last_activity', null)->get();
                break;
            default:
                return back()->withErrors('Option selected not defined.');
        }

        $message = $request->input('message');
        if (count($users) > 0)
        {
            foreach($users as $user)
            {
                if ($user->country == 'Zimbabwe')
                {
                    $this->send_message($user->phone, $message);
                }

                if(filter_var($user->email, FILTER_VALIDATE_EMAIL ))
                {
                    Mail::to($user->email)->send(new Announcement($message));
                }
            }
            $messageLog = new MessageLog;
            $messageLog->purpose = 'announcement';
            $messageLog->number = count($users);
            $messageLog->save();
        }
        else
        {
            return back()->withErrors('Option has no users selected');
        }

        return redirect('/announcement/create')->with('message', 'Successfully sent announcement');
    }
}
