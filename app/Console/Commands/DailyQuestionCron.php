<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Client;
use App\DailyQuestion;
use Carbon\Carbon;

class DailyQuestionCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyQuestion:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate for each active client dailyQuestions';

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

            DailyQuestion::create([
                'questions' => $questionArray,
                'scores' =>$scoresArray,
                'filled' => false,
                // 'created_at' => Carbon::now(),
                'filled_at' =>  Carbon::now(),
                'user_id' => $activeClient->user_id,

            ]);


        }





    }
}
