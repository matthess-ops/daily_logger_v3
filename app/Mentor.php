<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;


/**
 * App\Mentor
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
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor query()
 * @mixin \Eloquent
 */
class Mentor extends Model
{
    use Encryptable;

    protected $encryptable = [
        'firstname',
        'lastname',
        'street',
        'street_nr',
        'postcode',
        'phone_number',
        'city'
       
    ];
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
