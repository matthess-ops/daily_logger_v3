<?php

use App\DailyQuestion;
use Illuminate\Database\Seeder;
use App\Client;
use App\DailyActivity;
use Carbon\Carbon;

class DailyActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients =  client::all();
        foreach ($clients as $client) {
            $activities = $client->activities;
            $mainActivities = [];
            $scaledActivities=[];
            $scoreArray = [];
            foreach ($activities as $activity) {
                if($activity->type == "scaled"){
                    array_push($scaledActivities,$activity->value);
                    array_push($scoreArray,0);
                }elseif($activity->type == "main"){
                    array_push($mainActivities,$activity->value);

                }
            }
            $startDateTime = Carbon::now()->subDays(7);
            // for ($i=0; $i < 10; $i++) { 
            //     error_log("i = ".$i);
            // }

            for ($i=0; $i < 10; $i++)  {
                $startDateTime= $startDateTime->addDay();
                $newTimeSlots = [];
                $newMainActivities =[];
                $newScaledActivities=[];
                $newScaledActivitiesScores =[];

                for ($j=0; $j<= 95; $j++) {
                    array_push($newTimeSlots,$i);
                    $randMainActivity = $mainActivities[rand(0,count($mainActivities)-1)];
                    array_push($newMainActivities,$randMainActivity);
                    array_push($newScaledActivities,$scaledActivities);
                    array_push($newScaledActivitiesScores,$scoreArray);
                }

                DailyActivity::create([

                    'user_id'=>$client->id,
                    'time_slots'=>$newTimeSlots,
                    'main_activities'=>$newMainActivities,
                    'scaled_activities'=>$newScaledActivities,
                    'scaled_activities_scores'=>$newScaledActivitiesScores,
                    'created_at'=>$startDateTime,
                    'updated_at'=>$startDateTime,
                    'date_today'=>$startDateTime->format('Y-m-d'),

                ]);



            }
        }


    }
}
