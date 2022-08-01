<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    //comment relstionship
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    // user relationship
    public function user(){  //posts->user   person who wrote the comment
        return $this->belongsTo(User::class);
    }

    //adding comment logic
    public  function addComment($body){
        $this->comments()->create(compact('body'));
    }

    public function subject(){
        return $this->belongsTo('App\Subject');
    }
}
