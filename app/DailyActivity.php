<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{

    protected $fillable = [
        'user_id', 'time_slots', 'main_activities','scaled_activities','scaled_activities_scores','colors','date_today',
    ];


    protected $casts = [
        'time_slots' => 'array',
        'main_activities' => 'array',
        'scaled_activities' => 'array',
        'scaled_activities_scores' => 'array',
        'colors' => 'array',

    ];
}
