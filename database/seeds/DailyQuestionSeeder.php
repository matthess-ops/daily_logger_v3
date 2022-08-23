<?php

use App\Client;
use App\DailyQuestion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DailyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get all clients
        $clients = Client::all();
        foreach ($clients as $client) {
            // start date is 7 days ago
            $questions = [];
            $scores = [];

            $clientQuestions = $client->questions;
            //fill questions and scores arrays
            foreach ($clientQuestions as $clientQuestion) {
                array_push($questions, $clientQuestion->question);
                array_push($scores, rand(0, 10));
            }

            $startDateTime = Carbon::now()->subDays(7);
            for ($i = 0; $i < 7; $i++) {
                //pick random int to set filled field to true or false
                $randomInt = rand(0, 2);
                $startDateTime->addDay();
                if ($randomInt == 1) {
                    DailyQuestion::create([
                        'user_id' => $client->user_id,
                        'questions' => $questions,
                        'scores' => $scores,
                        'filled' => true,
                        'created_at' => $startDateTime,
                        'filled_at' => $startDateTime,
                    ]);
                } else {


                    DailyQuestion::create([
                        'user_id' => $client->user_id,
                        'questions' => $questions,
                        'scores' => $scores,
                        'filled' => false,
                        'created_at' => $startDateTime,
                        'filled_at' => $startDateTime,
                    ]);
                }
            }
        }
    }
}
