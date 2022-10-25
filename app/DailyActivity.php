<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DailyActivity
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property array $time_slots
 * @property array $main_activities
 * @property array $scaled_activities
 * @property array $scaled_activities_scores
 * @property string $date_today
 * @property array $colors
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity query()
 * @mixin \Eloquent
 */
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
        'time_values'=>'array',
        'started'=>'boolean',
        'completed'=>'boolean',


        // $table->boolean('started')->default(0);
        //     $table->boolean('completed')->default(0);
        //     $table->boolean('mentor_started')->default(0);
        //     $table->boolean('mentor_completed')->default(0);

    ];
}
