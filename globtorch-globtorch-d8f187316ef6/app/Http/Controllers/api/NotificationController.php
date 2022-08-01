<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = DB::table('notifications')
                    ->join('user_notifications', 'notifications.id', '=', 'user_notifications.notification_id')
                    ->select('notifications.*', 'user_notifications.isRead')
                    ->where('user_id', '=', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
        $num_unread_notifications = count(
                    DB::table('user_notifications')
                    ->select('*')
                    ->where([
                        ['user_id', '=', Auth::id()],
                        ['isRead', '=', 0]
                    ])->get());
        return response()->json(['num_unread_notifications'=>$num_unread_notifications, 'notifications'=>$notifications], 200);
    }
}
