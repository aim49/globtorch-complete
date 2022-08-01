<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
   
    protected $table = 'courses';
    public $timestamps = true;
    const created_at = 'creation_date';
    const updated_at = 'last_update';
    
    protected $fillable = ['name', 'introduction', 'level', 'price'];

    public static $validationRules = array(
        'name' => 'required|string',
        'introduction' => 'required|string',
        'level' => 'required|string',
        'price' => 'required|decimal',
        'price' => 'required|string',
    );

    public function subjects()
    {
        return $this->belongsToMany('App\Subject')
            ->withTimestamps();
    }

    /**
     * Relationship between User and Course
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'enrollments', 'course_id', 'user_id');
    }

    public function payments()
    {
        return $this->hasManyThrough('App\Payment','App\Enrollment');
    }

    public function exam_boards()
    {
        return $this->belongsToMany('App\Exam_Board', 'course_boards', 'course_id', 'board_id')
            ->withPivot('exam_months', 'exam_price')
            ->withTimestamps();
    }
}
