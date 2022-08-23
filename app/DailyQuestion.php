<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyQuestion extends Model
{
    protected $casts = [
        'filled_at' => 'datetime',
        'questions' => 'json',
        'scores' => 'json',
        'filled'=>'boolean'
    ];
}
