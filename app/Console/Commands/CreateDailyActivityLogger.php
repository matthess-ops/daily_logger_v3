<?php

namespace App\Console\Commands;

use App\Client;
use App\DailyActivity;
use Carbon\Carbon;
use Illuminate\Console\Command;



class CreateDailyActivityLogger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CreateDailyActivityLogger:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for each active user if an daily Activity needs to be made';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
