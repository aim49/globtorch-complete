<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function chapter(){
        return $this->belongsTo('App\Chapter');
    }

    public function contents(){
        return $this->hasMany('App\Content');  
    }
}
