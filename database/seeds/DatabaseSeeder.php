<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ClientSeeder::class);
        // $this->call(MentorSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(QuestionSeeder::class);
        // $this->call(DailyQuestionSeeder::class);
        // $this->call(DailyActivitySeeder::class);

    }
}
