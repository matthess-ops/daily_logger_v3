<?php

use App\Client;
use App\DailyQuestion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

//Seeder that create dailyQuestion entries for the daiyQuestion table
class DailyQuestionSeeder extends Seeder
{
    //generate and save for each client for each of the last x days an
    //dailyreport entry.
    public function run()
    {
        // get all clients
        $nrOfDaysToGenerateData = 60; // nr of days to generate entries for.

        $clients = Client::all();
        foreach ($clients as $client) {
            // $questions = [];
            // $scores = [];
            // $mentorScores = [];

            $clientQuestions = $client->questions;
            // foreach ($clientQuestions as $clientQuestion) {
            //     array_push($questions, $clientQuestion->question);
            //     array_push($scores, rand(0, 10));
            //     array_push($mentorScores,0);
            // }

            $startDateTime = Carbon::now()->subDays($nrOfDaysToGenerateData);
            for ($i = 0; $i < $nrOfDaysToGenerateData; $i++) {
                //pick random int to set filled field to true or false

                $questions = [];
                $scores = [];
                $mentorScores = [];
                $randScoreArraySeeds = [null,0,1,2,3,4,5,6,7,8,9,10];
                foreach ($clientQuestions as $clientQuestion) {
                    array_push($questions, $clientQuestion->question);
                    array_push($scores, $randScoreArraySeeds[array_rand($randScoreArraySeeds )]);
                    array_push($mentorScores,$randScoreArraySeeds[array_rand($randScoreArraySeeds )]);

                }


                $randomInt = rand(0, 2);
                $startDateTime->addDay();
                if ($randomInt == 1) {
                    DailyQuestion::create([
                        'user_id' => $client->user_id,
                        'questions' => $questions,
                        'scores' => $scores,
                        'mentor_scores'=>$mentorScores,
                        'mentor_id'=>null,
                        'filled' => true,
                        'mentor_filled'=>true,

                        'created_at' => $startDateTime,
                        'filled_at' => $startDateTime,
                        'mentor_filled_at'=> null,
                        'date_today' => $startDateTime->format('Y-m-d'),
                        'started' => rand(0,1),
                        'completed'=>rand(0,1),
                        'mentor_started' => rand(0,1),
                        'mentor_completed'=>rand(0,1),
                    ]);
                } else {


                    DailyQuestion::create([
                        'user_id' => $client->user_id,
                        'questions' => $questions,
                        'scores' => $scores,
                        'mentor_scores'=>$mentorScores,
                        'mentor_id'=>null,
                        'filled' => false,
                        'mentor_filled'=>false,
                        'created_at' => $startDateTime,
                        'filled_at' => $startDateTime,
                        'mentor_filled_at'=> null,
                        'date_today' => $startDateTime->format('Y-m-d'),
                        'started' => rand(0,1),
                        'completed'=>rand(0,1),
                    ]);
                }
            }
        }
    }
}
