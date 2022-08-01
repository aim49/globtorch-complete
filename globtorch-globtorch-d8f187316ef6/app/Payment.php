<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'payments';
    public $timestamps = true;
    const created_at = 'creation_date';
    const updated_at = 'last_update';
    protected $fillable = ['date','start_date','end_date','method','amount','ref', 'enrollment_id'];

    public static $validationRules = array(
        'date' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'method' => 'required',
        'amount' => 'required',
        'ref' => 'required',
        'enrollment_id' => 'required',
    );
}
