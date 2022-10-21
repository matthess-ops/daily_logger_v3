<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Client;

/**
 * App\Question
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property string $question
 * @property-read Client|null $client
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @mixin \Eloquent
 */
class Question extends Model
{
    public function client(){
        return $this->hasOne(Client::class,'user_id','user_id');
    }
}
