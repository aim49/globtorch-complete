<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    public function topic(){
        return $this->belongsTo('App\Topic');
    }
}
