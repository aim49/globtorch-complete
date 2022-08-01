<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }
}
