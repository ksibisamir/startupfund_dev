<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $table = "teams";


    public $fillable = [
        'name',
        'user_id',
        'fonction',
        'social_network_link'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
