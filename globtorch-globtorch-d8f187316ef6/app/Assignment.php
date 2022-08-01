<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
  // 
  protected $table = 'assignments';
  public $timestamps = true;
  const created_at = 'creation_date';
  const updated_at = 'last_update';
  
  protected $fillable = ['subject_id', 'user_id', 'name', 'due_date','file_path'];

  public static $validationRules = array(
      'subject_id' => 'required',
      'user_id' => 'required',
      'name' => 'required',
      'due_date' => 'required',
      'file_path' => 'required',
  );
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
  public function teachersubject()
  {
     // 
      return $this->belongsTo('App\TeacherSubjects');
      
  }
  public function assignmentanswer()
  {
     // 
      return $this->hasMany('App\AssignmentAnswer');
      
  }

  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
