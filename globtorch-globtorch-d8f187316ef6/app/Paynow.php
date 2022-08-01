<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paynow extends Model
{
    //
    protected $table = 'paynow_transactions';
    public $timestamps = true;
    const created_at = 'creation_date';
    const updated_at = 'last_update';
    
    protected $fillable = ['ref', 'url','course_id','user_id','enrollment_id'];

    public static $validationRules = array(
        'ref' => 'required|string',
        'url' => 'required|string',
        'course_id' => 'required',
        'user_id' => 'required',
        'enrollment_id' => 'required',
    );
}
