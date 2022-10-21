<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Client
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $street
 * @property string $street_nr
 * @property string $postcode
 * @property string $phone_number
 * @property string $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @mixin \Eloquent
 */
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
