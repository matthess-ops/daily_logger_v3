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
        $nrOfDaysToGenerateData = 120; // nr of days to generate entries for.
        $clients =  client::all();
        foreach ($clients as $client) {
            $activities = $client->activities; // get activities from the client model
            $mainActivities = [];
            $scaledActivities = [];
            $scoreArray = []; // score array with only zeros
            $colors = []; // each main activity has its own unique color
            foreach ($activities as $activity) {
                if ($activity->type == "scaled") {
                    array_push($scaledActivities, $activity->value);
                    array_push($scoreArray, 0);
                } elseif ($activity->type == "main") {
                    array_push($mainActivities, $activity->value);
                    array_push($colors, $activity->color);
                }
            }
            $startDateTime = Carbon::now()->subDays($nrOfDaysToGenerateData)->startOfDay();


            for ($i = 0; $i < $nrOfDaysToGenerateData; $i++) {
                $startDateTime = $startDateTime->addDay();
                $newTimeSlots = [];
                $newMainActivities = [];
                $newScaledActivities = [];
                $newScaledActivitiesScores = [];
                $newMainActivitiesColors = [];
                $newTimeValues = [];
                //60 minutes /4 *24 = 96
                // since index 0 is counted put $j on 95
                // admin should be able to choose between 0900 to 1700 and full 24 hour day activity logging




                // 24 hours
                //60 minutes /4 *24 = 96
                // since index 0 is counted put $j on 95

                $timeSelection = rand(1,1); //when 0 selected the timeslots should be 8 hour workday


                if ($timeSelection == 0) {
                    $timeValuesStartTime = $startDateTime->copy();
                    for ($j = 0; $j <= 95; $j++) {
                        array_push($newTimeSlots, $j);

                        array_push($newTimeValues,$timeValuesStartTime->clone());
                        $timeValuesStartTime->addMinutes(15);

                        $randInt = rand(0, count($mainActivities) - 1);
                        //for testing purposes not each timeslot/timeinterval is assigned and mainActivity
                        //only one out of 3 timeslots are given an mainactivity and its associated color
                        //if a time slot has a null mainativity the scaledActivites scorearray should contain all zeros
                        if (rand(0, 3) == 2) {
                            $randMainActivity = null;
                            $randMainActivityColor = null;
                            array_push($newScaledActivitiesScores, $scoreArray);
                        } else {
                            $randMainActivity = $mainActivities[$randInt];
                            $randMainActivityColor = $colors[$randInt];
                            $randScoreArray = [];
                            // if timeslot has an main activity the the scorearray should contain random values 0-10
                            foreach ($scoreArray as $score) {
                                $randomScore = rand(0, 10);
                                array_push($randScoreArray, $randomScore);
                            }
                            array_push($newScaledActivitiesScores, $randScoreArray);
                        }

                        array_push($newMainActivities, $randMainActivity);
                        array_push($newScaledActivities, $scaledActivities);
                        array_push($newMainActivitiesColors, $randMainActivityColor);
                    }
                }
                if ($timeSelection == 1) {
                    $timeValuesStartTime = $startDateTime->copy();

                    $timeValuesStartTime->addHours(9);

                    for ($j = 0; $j <= 31; $j++) {
                        array_push($newTimeSlots, $j);


                        array_push($newTimeValues,$timeValuesStartTime->clone());
                        $timeValuesStartTime->addMinutes(15);

                        $randInt = rand(0, count($mainActivities) - 1);
                        //for testing purposes not each timeslot/timeinterval is assigned and mainActivity
                        //only one out of 3 timeslots are given an mainactivity and its associated color
                        //if a time slot has a null mainativity the scaledActivites scorearray should contain all zeros
                        if (rand(0, 3) == 2) {
                            $randMainActivity = null;
                            $randMainActivityColor = null;
                            array_push($newScaledActivitiesScores, $scoreArray);
                        } else {
                            $randMainActivity = $mainActivities[$randInt];
                            $randMainActivityColor = $colors[$randInt];
                            $randScoreArray = [];
                            // if timeslot has an main activity the the scorearray should contain random values 0-10
                            foreach ($scoreArray as $score) {
                                $randomScore = rand(0, 10);
                                array_push($randScoreArray, $randomScore);
                            }
                            array_push($newScaledActivitiesScores, $randScoreArray);
                        }

                        array_push($newMainActivities, $randMainActivity);
                        array_push($newScaledActivities, $scaledActivities);
                        array_push($newMainActivitiesColors, $randMainActivityColor);
                    }
                }



                DailyActivity::create([

                    'user_id' => $client->id,
                    'time_slots' => $newTimeSlots,
                    'main_activities' => $newMainActivities,
                    'scaled_activities' => $newScaledActivities,
                    'scaled_activities_scores' => $newScaledActivitiesScores,
                    'colors' => $newMainActivitiesColors,
                    'created_at' => $startDateTime,
                    'updated_at' => $startDateTime,
                    'date_today' => $startDateTime->format('Y-m-d'),
                    'time_values'=>$newTimeValues,
                    'started' => rand(0,1),
                    'completed'=>rand(0,1),
                ]);
            }
        }
    }
}
