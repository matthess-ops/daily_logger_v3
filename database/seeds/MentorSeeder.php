<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;
use App\Mentor;

//Seeder to create mentor entries for the mentor table
class MentorSeeder extends Seeder
{
    // check for each user if the user has an role of mentor. If so
    // create for this user and mentor entry in the mentor table
    public function run(Faker $faker)
    {
        $users = User::all();
        foreach ($users as $user) {
            if($user->role == "mentor"){
                Mentor::create([
                    'user_id'=>$user->id,
                    'firstname'=>$faker->firstname,
                    'lastname'=>$faker->lastname,
                    'street'=>$faker->streetName,
                    'street_nr'=>rand(0,100),
                    'postcode'=>$faker->postcode,
                    'phone_number'=>$faker->phoneNumber,
                    'city'=>$faker->city,
                ]);
            }}
    }
}
