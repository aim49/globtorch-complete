<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_Board extends Model
{
    //
    protected $table = 'exam_boards';
    public $timestamps = true;
    const created_at = 'creation_date';
    const updated_at = 'last_update';
    
    protected $fillable = ['name', 'description'];

    public static $validationRules = array(
        'name' => 'required|string',
        'description' => 'required|string',
    );

    public function courses()
    {
        return $this->belongsToMany('App\Exam_Board', 'course_boards', 'board_id', 'course_id')
            ->withPivot('exam_months', 'exam_price')
            ->withTimestamps();
    }
}
