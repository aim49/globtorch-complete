<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //discussion relationship
    public function  discussion(){
        return $this->belongsTo(Discussion::class);
    }

    //user relationship
    public function  user(){
        return $this->belongsTo(User::class);
    }
}
