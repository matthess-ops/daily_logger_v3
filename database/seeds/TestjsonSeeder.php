<?php

use App\Testjson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TestjsonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $loop = 0;

        for ($loop = 0; $loop < 10; $loop++) {

        Testjson::create([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'test_id' => "test_".$loop,
            'test_array' => [1,2,3,4,5],
        ]);
    }
    }
}
