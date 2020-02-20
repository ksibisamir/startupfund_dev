<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikedComment extends Model
{
    protected $guarded = [];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->belongsTo(Comment::class);
    }
}
