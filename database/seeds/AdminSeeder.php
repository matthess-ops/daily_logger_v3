<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;
use App\Admin;

//Seeder that creates and save admins to to admin table
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //for each user in the user table check if the user role is admin
    //if so create for this user and admin entry in the admin table
    public function run(Faker $faker)
    {
        $users = User::all();
        foreach ($users as $user) {
            if($user->role == "admin"){
                Admin::create([
                    'user_id'=>$user->id,
                    'firstname'=>$faker->firstname,
                    'lastname'=>$faker->lastname,

                ]);
            }
        }
    }
}
