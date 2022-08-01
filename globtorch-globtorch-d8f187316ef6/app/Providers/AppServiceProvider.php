<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('*', function($view){
            if(Auth::user())
            {
                $notifications = DB::table('notifications')
                    ->join('user_notifications', 'notifications.id', '=', 'user_notifications.notification_id')
                    ->select('notifications.*', 'user_notifications.isRead')
                    ->where('user_id', '=', Auth::user()->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                $unread_notifications = count(
                    DB::table('user_notifications')
                    ->select('*')
                    ->where([
                        ['user_id', '=', Auth::user()->id],
                        ['isRead', '=', 0]
                    ])->get());
                $unread_chats = count(DB::table('chat_rooms')
                        ->join('messages', 'chat_rooms.id', 'messages.chat_room_id')
                        ->where([
                            ['messages.user_id', '<>', Auth::id()],
                            ['is_read', 0]
                            ])
                        ->whereRaw('FIND_IN_SET(?,participants)', Auth::id())
                        ->get());
                View::share('notifications',$notifications);
                View::share('unread_notifications',$unread_notifications);
                View::share('unread_chats', $unread_chats);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
