<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // function to generate an api token and save it
    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    //creating a many to many relationship with discussion
    public function discussions(){
        return $this->hasMany(Discussion::class);
    }

    //creatinga a one to many relationship with subject
    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'teacher_subjects', 'user_id', 'subject_id');
    }

    public function teacher_subjects()
    {
        return $this->hasMany('App\TeacherSubject');
    }

    /**
     * Relationship between User and Course
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course', 'enrollments', 'user_id', 'course_id');
    }

    /**
     * Relationship between User and Notifications
     */
    public function notifications()
    {
        return $this->belongsToMany('App\Notification', 'user_notifications', 'user_id', 'notification_id');
    }

    public function assignment_answers()
    {
        return $this->hasMany('App\AssignmentAnswer');
    }

    public function login_histories()
    {
        return $this->hasMany('App\LoginHistory');
    }

    public function teacher_activities()
    {
        return $this->hasMany('App\TeacherActivity');
    }

    //user ratings
    public function teacher_ratings()
    {
        return $this->hasMany('App\TeacherRating', 'teacher_id');
    }

    public function students_teacher_ratings()
    {
        return $this->hasMany('App\TeacherRating', 'student_id');
    }
}
