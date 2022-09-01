<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Client;

class Question extends Model
{
    public function client(){
        return $this->hasOne(Client::class,'user_id','user_id');
    }
}
