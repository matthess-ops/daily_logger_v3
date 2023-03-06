<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testjson extends Model
{
    protected $fillable = [
        'test_id', 'test_array',
    ];

    public function getTestArrayAttribute($value)
    {
        return json_decode($value);
    }

    public function setTestArrayAttribute($value)
    {
        $this->attributes['test_array'] = json_encode($value);
    }





}
