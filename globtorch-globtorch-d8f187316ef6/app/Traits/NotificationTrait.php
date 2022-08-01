<?php

namespace App\Traits;

use App\Notification;
use App\UserNotification;

trait NotificationTrait
{
    /**
     * create notification for users
     * users expected as an array
     * except $id
     */
    protected function create_notification($title, $body, $link, $users, $id)
    {
        $notification = new Notification;
        $notification->title = $title;
        $notification->body = $body;
        $notification->link = $link;
        $notification->save();

        foreach($users as $user)
        {
            if ($user != null)
            {
                if ($user->id != $id)
                {
                    $user_notification = new UserNotification;
                    $user_notification->notification_id = $notification->id;
                    $user_notification->user_id = $user->id;
                    $user_notification->save();
                }
            }
        }
    }
}

?>