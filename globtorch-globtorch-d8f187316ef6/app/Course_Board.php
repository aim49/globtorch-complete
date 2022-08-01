<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_Board extends Model
{
    // 
    protected $table = 'course_boards';
    public $timestamps = true;
    const created_at = 'creation_date';
    const updated_at = 'last_update';
    
    protected $fillable = ['course_id', 'board_id', 'exam_months', 'exam_price'];

    public static $validationRules = array(
        'course_id' => 'required|string',
        'board_id' => 'required|string',
        'exam_months' => 'required|string',
        'exam_price' => 'required|decimal',
    );
    public function course()
    {
       // link course using course id
        return $this->belongsTo('App\Course');
        
    }
    public function board()
    {
       // link table exam_board using board id
        return $this->belongsTo('App\Exam_Board');
        
    }
 
}
