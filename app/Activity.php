<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Activity
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property string $value
 * @property string|null $color
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @mixin \Eloquent
 */
class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'user_id', 'type', 'value','created_at','updated_at','color',
    ];

}
