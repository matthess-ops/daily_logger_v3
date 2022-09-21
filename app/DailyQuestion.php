<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyQuestion extends Model
{
    protected $fillable = [
        'user_id', 'questions', 'scores','filled','filled_at'
    ];


    protected $casts = [
        'filled_at' => 'datetime',
        'mentor_filled_at'=> 'datetime',
        'questions' => 'json',
        'scores' => 'json',
        'mentor_scores'=>'json',
        'filled'=>'boolean',
        'mentor_filled'=>'boolean',

    ];

    public function client(){
        return $this->hasOne(Client::class,'user_id','user_id');
    }
}
