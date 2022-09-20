<?php

namespace App\Console\Commands;

use App\Client;
use App\DailyActivity;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DailyActivityCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyActivity:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily activity entry';

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
        \Log::info('Daily activity cron called');
        $clients = Client::all();

        $activeClients = [];
        foreach ($clients as $client) {
            $user = $client->user;
            if ($user->active == true) {
                array_push($activeClients, $client);
            }
        }
        \Log::info("dailyactivity cron active clients " . count($activeClients));

        foreach ($activeClients as $activeClient) {
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

            for ($i=0; $i <= 95 ; $i++) {
                array_push($mainActivitiesArray,null);
                array_push($scaledActivitiesArray,$scaledActivities);
                array_push($timeSlotsArray,$i);
                array_push($scaledActivitiesScoresArray,$scaledActivitiesScores);
                array_push($colorsArray,null);
            }
            \Log::info("dailyactivity cron scaled acts  " . json_encode($scaledActivities));



            DailyActivity::create([

                'user_id'=>$activeClient->user_id,
                'time_slots'=>$timeSlotsArray,
                'main_activities'=>$mainActivitiesArray,
                'scaled_activities'=>$scaledActivitiesArray,
                'scaled_activities_scores'=>$scaledActivitiesScoresArray,
                'colors'=>$colorsArray,
                // 'created_at'=>$startDateTime,
                // 'updated_at'=>$startDateTime,
                'date_today'=>Carbon::now()->format('Y-m-d'),

            ]);


        }
    }
}
