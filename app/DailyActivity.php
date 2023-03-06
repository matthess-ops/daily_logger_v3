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
        'user_id', 'time_slots', 'main_activities','scaled_activities','scaled_activities_scores','colors','date_today','time_values',
    ];

    public function getTimeSlotsAttribute($value)
    {
        return json_decode($value);
    }

    public function setTimeSlotsAttribute($value)
    {
        $this->attributes['time_slots'] = json_encode($value);
    }

    public function getMainActivitiesAttribute($value)
    {
        return json_decode($value);
    }

    public function setMainActivitiesAttribute($value)
    {
        $this->attributes['main_activities'] = json_encode($value);
    }

    public function getScaledActivitiesAttribute($value)
    {
        return json_decode($value);
    }

    public function setScaledActivitiesAttribute($value)
    {
        $this->attributes['scaled_activities'] = json_encode($value);
    }

    public function getScaledActivitiesScoresAttribute($value)
    {
        return json_decode($value);
    }

    public function setScaledActivitiesScoresAttribute($value)
    {
        $this->attributes['scaled_activities_scores'] = json_encode($value);
    }

    public function getColorsAttribute($value)
    {
        return json_decode($value);
    }

    public function setColorsAttribute($value)
    {
        $this->attributes['colors'] = json_encode($value);
    }

    public function getTimeValuesAttribute($value)
    {
        return json_decode($value);
    }

    public function setTimeValuesAttribute($value)
    {
        $this->attributes['time_values'] = json_encode($value);
    }



    protected $casts = [
        // 'time_slots' => 'array',
        // 'main_activities' => 'array',
        // 'scaled_activities' => 'array',
        // 'scaled_activities_scores' => 'array',
        // 'colors' => 'array',
        // 'time_values'=>'array',
        'started'=>'boolean',
        'completed'=>'boolean',

    ];
}
