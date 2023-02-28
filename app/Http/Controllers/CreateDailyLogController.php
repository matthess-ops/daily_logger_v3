<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Console\Commands\CreateDailyActivityLogger;
use App\DailyActivity;
use Carbon\Carbon;
use App\DailyQuestion;

//Since i dont have a cronjob capability on my webserver i will have to use
//https://console.cron-job.org/login i have tried to make aan schedule:run call
//however that didnt work therefore i am making an createDailyLogController that creates
//the activiest and dailyquestion logs
class CreateDailyLogController extends Controller
{
    public function run(){

        $this->createDailyActivityLogger();
        $this->CreateDailyQuestionLogger();
    }

    private function createDailyQuestionLogger()
    {
        \Log::info("daily question cron called");
        $clients = Client::all();

        $activeClients = [];
        foreach ($clients as $client) {
            $user = $client->user;
            if($user->active == true){
                array_push($activeClients,$client);
            }
        }
        \Log::info("num of active clients ".count($activeClients ));

        foreach ($activeClients as $activeClient) {
            $questionArray = [];
            $scoresArray = [];
            $questions = $activeClient->questions;
            foreach ($questions as $question) {
                array_push($questionArray,$question->question);
                array_push($scoresArray,0);
            }
            // \Log::info("num of questions ".json_encode($questions));

            $dailyQuestion = new DailyQuestion();
            $dailyQuestion->user_id =  $activeClient->user_id;
            $dailyQuestion->questions =$questionArray;

            $dailyQuestion->scores =$scoresArray;
            $dailyQuestion->date_today =Carbon::now()->format('Y-m-d');
            $dailyQuestion->mentor_scores =$scoresArray;


            $dailyQuestion->save();

            //     'mentor_id'=>null,
            //     'filled' => false,
            //     'mentor_filled'=>false,
            //     'date_today'=>Carbon::now()->format('Y-m-d'),
            //     'mentor_scores' =>$scoresArray,
            //     'mentor_filled_at'=> null,
            //     'started' => false,
            //     'completed'=>false,
            //     'mentor_started' => false,
            //     'mentor_completed'=>false,
            //     // 'client_remark'=> "",
            //     // 'mentor_remark'=>"",
            // ]);


        }





    }

    private function createDailyActivityLogger()
    {
        \Log::info("CreateDailyActivityLogger:cron started");

        $clients = Client::all();
        $activeClients = [];

        foreach ($clients as $client) {
            $user = $client->user;
            if ($user->active == true) {
                array_push($activeClients, $client);
            }
        }

        foreach ($activeClients as $activeClient) {
            \Log::info("CreateDailyActivityLogger:cron". $activeClient->user_id);

            $activities = $activeClient->activities;
            $scaledActivities = [];
            $scaledActivitiesScores = [];
            foreach ($activities as $activity) {
                if($activity->type== 'scaled'){
                array_push($scaledActivities,$activity->value);
                array_push($scaledActivitiesScores,0);
                }
            }

            $mainActivitiesArray = [];
            $scaledActivitiesArray = [];
            $scaledActivitiesScoresArray = [];
            $timeSlotsArray = [];
            $colorsArray = [];
            $timeValuesArray = [];

            $startDateTime = Carbon::now()->startOfDay()->addHours(9);

            $timeValuesStartTime = $startDateTime->copy();


            if($client->activity_time == "24hour"){
                \Log::info("CreateDailyActivityLogger:cron 24hour stuff stuff");

                for ($i=0; $i <= 95 ; $i++) {

                    array_push($mainActivitiesArray,null);
                    array_push($scaledActivitiesArray,$scaledActivities);
                    array_push($timeSlotsArray,$i);
                    array_push($scaledActivitiesScoresArray,$scaledActivitiesScores);
                    array_push($colorsArray,null);
                    array_push($timeValuesArray,$timeValuesStartTime->clone());
                    $timeValuesStartTime->addMinutes(15);
                }

            }

            if($client->activity_time == "workday"){
                \Log::info("CreateDailyActivityLogger:cron workday stuff");

                for ($i=0; $i <= 31 ; $i++) {
                    array_push($mainActivitiesArray,null);
                    array_push($scaledActivitiesArray,$scaledActivities);
                    array_push($timeSlotsArray,$i);
                    array_push($scaledActivitiesScoresArray,$scaledActivitiesScores);
                    array_push($colorsArray,null);
                    array_push($timeValuesArray,$timeValuesStartTime->clone());
                    $timeValuesStartTime->addMinutes(15);
                }

            }





            DailyActivity::create([

                // 'user_id'=>$activeClient->user_id,
                // 'time_slots'=>$timeSlotsArray,
                // 'main_activities'=>$mainActivitiesArray,
                // 'scaled_activities'=>$scaledActivitiesArray,
                // 'scaled_activities_scores'=>$scaledActivitiesScoresArray,
                // 'colors'=>$colorsArray,

                // 'date_today'=>Carbon::now()->format('Y-m-d'),

                'user_id'=>$activeClient->user_id,
                'time_slots' => $timeSlotsArray,
                'main_activities' => $mainActivitiesArray,
                'scaled_activities' => $scaledActivitiesArray,
                'scaled_activities_scores' => $scaledActivitiesScoresArray,
                'date_today'=>Carbon::now()->format('Y-m-d'),
                'colors' => $colorsArray,
                'time_values'=>$timeValuesArray,
                'started'=>false,
                'completed'=>false,

                // 'user_id' => $client->id,
                // 'time_slots' => $newTimeSlots,
                // 'main_activities' => $newMainActivities,
                // 'scaled_activities' => $newScaledActivities,
                // 'scaled_activities_scores' => $newScaledActivitiesScores,
                // 'colors' => $newMainActivitiesColors,
                // 'created_at' => $startDateTime,
                // 'updated_at' => $startDateTime,
                // 'date_today' => $startDateTime->format('Y-m-d'),
                // 'time_values'=>$newTimeValues,
                // 'started' => rand(0,1),
                // 'completed'=>rand(0,1),


            ]);


        }



        \Log::info("CreateDailyActivityLogger:cron finished");
    }
}
