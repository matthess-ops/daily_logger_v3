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
        'questions' => 'json',
        'scores' => 'json',
        'filled'=>'boolean',

    ];
}
