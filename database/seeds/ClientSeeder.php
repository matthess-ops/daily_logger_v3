<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;
use App\Client;

//Seeder for the client table
class ClientSeeder extends Seeder
{
   //check and create for all users if an user has an role of client
   //if so create for the user and client entry in the client table
    public function run(Faker $faker)
    {
        $users = User::all();
        foreach ($users as $user) {
            if($user->role == "client"){
                Client::create([
                    'user_id'=>$user->id,
                    'firstname'=>$faker->firstname,
                    'lastname'=>$faker->lastname,
                    'street'=>$faker->streetName,
                    'street_nr'=>rand(0,100),
                    'postcode'=>$faker->postcode,
                    'phone_number'=>$faker->phoneNumber,
                    'city'=>$faker->city,
                    'activity_time'=> ['24hour','workday'][array_rand(['24hour','workday'], 1)],
                ]);
            }
        }
    }
}
