<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherRating extends Model
{
    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }
}
