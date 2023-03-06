<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DailyQuestion
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property array $questions
 * @property array $scores
 * @property array $mentor_scores
 * @property string|null $mentor_id
 * @property \Illuminate\Support\Carbon|null $filled_at
 * @property \Illuminate\Support\Carbon|null $mentor_filled_at
 * @property bool $filled
 * @property bool $mentor_filled
 * @property-read \App\Client|null $client
 * @method static \Illuminate\Database\Eloquent\Builder|DailyQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyQuestion query()
 * @mixin \Eloquent
 */
class DailyQuestion extends Model
{
    // protected $fillable = [
    //     'user_id', 'questions', 'scores','filled','filled_at','date_today'
    // ];

    public function getQuestionsAttribute($value)
    {
        return json_decode($value);
    }

    public function setQuestionsAttribute($value)
    {
        $this->attributes['questions'] = json_encode($value);
    }

    public function getScoresAttribute($value)
    {
        return json_decode($value);
    }

    public function setScoresAttribute($value)
    {
        $this->attributes['scores'] = json_encode($value);
    }

    public function getMentorScoresAttribute($value)
    {
        return json_decode($value);
    }

    public function setMentorScoresAttribute($value)
    {
        $this->attributes['mentor_scores'] = json_encode($value);
    }


    protected $casts = [
        'filled_at' => 'datetime',
        'mentor_filled_at'=> 'datetime',
        // 'questions' => 'json',
        // 'scores' => 'json',
        // 'mentor_scores'=>'json',
        'filled'=>'boolean',
        'mentor_filled'=>'boolean',
        'client_remark'=>'string',
        'mentor_remark'=>'string',
        'started'=>'boolean',
        'completed'=>'boolean',
        'mentor_started'=>'boolean',
        'mentor_completed'=>'boolean'
    ];

    public function client(){
        return $this->hasOne(Client::class,'user_id','user_id');
    }
}
