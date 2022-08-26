<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    protected $casts = [
        'time_slots' => 'array',
        'main_activities' => 'array',
        'scaled_activities' => 'array',
        'scaled_activities_scores' => 'array',
        'colors' => 'array',

    ];
}
