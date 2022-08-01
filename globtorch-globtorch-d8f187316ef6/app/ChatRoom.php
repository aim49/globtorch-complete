<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
