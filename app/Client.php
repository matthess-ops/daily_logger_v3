<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function questions(){
        return $this->hasMany(Question::class,'user_id','user_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class,'user_id','user_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

}
