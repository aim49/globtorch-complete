<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_notifications', 'notification_id', 'user_id');
    }
}
