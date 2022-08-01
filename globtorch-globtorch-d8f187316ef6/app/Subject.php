<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function chapters()
    {
        return $this->hasMany('App\Chapter');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course')
            ->withTimestamps();
    }

    public function users(){
        return $this->belongsToMany('App\User', 'teacher_subjects', 'subject_id', 'user_id');
    }

    public function discussions(){
        return $this->hasMany('App\Discussion');
    }

    public function assignments(){
        return $this->hasMany('App\Assignment');
    }
}
