<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function chatRoom()
    {
        return $this->belongsTo('App\ChatRoom');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
