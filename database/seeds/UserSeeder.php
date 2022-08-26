<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{

    public function run()
    {
         // number of random client, admin, mentor users to make
         $numOfClients = 10;
         $numOfAdmins = 0;
         $numOfMentors = 0;



         //create a user with a client role
         User::create([
             'name' => 'client',
             'email' => 'client@gmail.com',
             'password' => bcrypt('password'),
             'active' => true,
             'role' => 'client',

         ]);

         //create a user with a admin role
         User::create([
             'name' => 'admin',
             'email' => 'admin@gmail.com',
             'password' => bcrypt('password'),
             'active' => true,
             'role' => 'admin',
         ]);
         //create a user with a mentor role
         User::create([
             'name' => 'mentor',
             'email' => 'mentor@gmail.com',
             'password' => bcrypt('password'),
             'active' => true,
             'role' => 'mentor',
         ]);

         for ($client = 0; $client < $numOfClients; $client++) {
             User::create([
                 'name' => 'client_' . $client,
                 'email' => 'client_' . $client . '@gmail.com',
                 'password' => bcrypt('password'),
                 'active' => true,
                 'role' => 'client',
             ]);
         }

         for ($admin = 0; $client < $numOfAdmins; $admin++) {
             User::create([
                 'name' => 'admin_' . $admin,
                 'email' => 'admin_' . $admin . '@gmail.com',
                 'password' => bcrypt('password'),
                 'active' => true,
                 'role' => 'admin',
             ]);
         }

         for ($mentor = 0; $mentor < $numOfMentors; $mentor++) {
             User::create([
                 'name' => 'mentor_' . $mentor,
                 'email' => 'mentor_' . $mentor . '@gmail.com',
                 'password' => bcrypt('password'),
                 'active' => true,
                 'role' => 'mentor',
             ]);
         }
    }
}
