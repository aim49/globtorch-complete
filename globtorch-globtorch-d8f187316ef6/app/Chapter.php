<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    public function topics()
    {
        return ($this->hasMany('App\Topic'));
    }

    public function subject()
    {
        return ($this->belongsTo('App\Subject'));
    }

    public function questions()
    {
        return ($this->hasMany('App\ChapterQuestion'));
    }

    public function results()
    {
        return ($this->hasMany('App\ChapterResult'));
    }
}
