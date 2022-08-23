<?php

use App\Activity;
use App\Client;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    //pick a random string from an array without duplicates
    //$type = scale or main
    //user_id = is the user id
    //$activities = an arary of activities
    public function pickRandomFromArray(array $activities, string $type, string $user_id)
    {
        $numToPick =  rand(1, count($activities));
        for ($i = 0; $i < $numToPick; $i++) {
            $randActivityIndex = rand(0, count($activities) - 1);
            $randActivity = $activities[$randActivityIndex];
            $newActivities = [];
            foreach ($activities as $activity) {
                if ($activity != $randActivity) {
                    array_push($newActivities, $activity);
                }
            }
            $activities = $newActivities;
            Activity::create([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => $user_id,
                'value' => $randActivity,
                'type' => $type,
            ]);
        }
    }
    public function run()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            $scaledActivities = ["Hoe voel je.", "Humeur", "Gestresst", "Gespannen", "Drukte", "Verdrietig"];
            $mainActivities = ["Werken", "Pauze", "Eten", "Afwassen", "Boodschappen doen.", "Strijken", "Programmeren", "Lezen", "Tv kijken", "Douchen", "Overig"];

            $user_id =  $client->user_id;

            $this->pickRandomFromArray($scaledActivities, 'scaled', $user_id);
            $this->pickRandomFromArray($mainActivities, 'main', $user_id);
        }
    }
}
