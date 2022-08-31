<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
