<?php

use App\DailyQuestion;
use Illuminate\Database\Seeder;
use App\Client;
use App\DailyActivity;
use Carbon\Carbon;

//Seeder for the dailyactivity table
class DailyActivitySeeder extends Seeder
{
    //for each client in the client table generate for each of last x days
    // and dailyActivity entry in the dailyActivity table.
    // An client needs to track their activities on an 15 min time interval/timeslot

    public function run()
    {
        $nrOfDaysToGenerateData = 7; // nr of days to generate entries for.
        $clients =  client::all();
        foreach ($clients as $client) {
            $activities = $client->activities; // get activities from the client model
            $mainActivities = [];
            $scaledActivities=[];
            $scoreArray = [];
            $colors = []; // each main activity has its own unique color
            foreach ($activities as $activity) {
                if($activity->type == "scaled"){
                    array_push($scaledActivities,$activity->value);
                    array_push($scoreArray,0);
                }elseif($activity->type == "main"){
                    array_push($mainActivities,$activity->value);
                    array_push($colors,$activity->color);

                }
            }
            $startDateTime = Carbon::now()->subDays($nrOfDaysToGenerateData);


            for ($i=0; $i < $nrOfDaysToGenerateData; $i++)  {
                $startDateTime= $startDateTime->addDay();
                $newTimeSlots = [];
                $newMainActivities =[];
                $newScaledActivities=[];
                $newScaledActivitiesScores =[];
                $newMainActivitiesColors = [];
                //60 minutes /4 *24 = 96
                // since index 0 is counted put $j on 95
                for ($j=0; $j<= 95; $j++) {
                    array_push($newTimeSlots,$j);
                    $randInt = rand(0,count($mainActivities)-1);
                    //for testing purposes not each timeslot/timeinterval is assigned and mainActivity
                    //only one out of 3 timeslots are given an mainactivity and its associated color
                    if(rand(0,3) == 2){
                        $randMainActivity = null;
                        $randMainActivityColor = null;
                    }else{
                        $randMainActivity = $mainActivities[$randInt];
                        $randMainActivityColor = $colors[$randInt];
                    }

                    array_push($newMainActivities,$randMainActivity);
                    array_push($newScaledActivities,$scaledActivities);
                    array_push($newScaledActivitiesScores,$scoreArray);
                    array_push($newMainActivitiesColors,$randMainActivityColor );

                }

                DailyActivity::create([

                    'user_id'=>$client->id,
                    'time_slots'=>$newTimeSlots,
                    'main_activities'=>$newMainActivities,
                    'scaled_activities'=>$newScaledActivities,
                    'scaled_activities_scores'=>$newScaledActivitiesScores,
                    'colors'=>$newMainActivitiesColors,
                    'created_at'=>$startDateTime,
                    'updated_at'=>$startDateTime,
                    'date_today'=>$startDateTime->format('Y-m-d'),

                ]);



            }
        }


    }
}
