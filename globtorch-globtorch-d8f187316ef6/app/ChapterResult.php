<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChapterResult extends Model
{
    public function chapter()
    {
        return $this->belongsTo('App\Chapter');
    }
}
