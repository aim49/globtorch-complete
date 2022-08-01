<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentAnswer extends Model
{
    //
    protected $table = 'assignment_answers';
    public $timestamps = true;
    const created_at = 'creation_date';
    const updated_at = 'last_update';
    
    protected $fillable = ['assignment_id', 'user_id', 'file_path', 'mark'];
  
    public static $validationRules = array(
        'subject_id' => 'required|integer',
        'user_id' => 'required|integer',
        'file_path' => 'required|string',
        'mark' => 'required|number',

    );
    public function assignment()
    {
       // 
        return $this->belongsTo('App\Assignment');
        
    }
    public function course()
    {
       // 
        return $this->belongsTo('App\Course');
        
    }
    public function subject()
    {
       // 
        return $this->belongsTo('App\Subject');
        
    }
    public function user()
    {
       // 
        return $this->belongsTo('App\User');
        
    }
}
