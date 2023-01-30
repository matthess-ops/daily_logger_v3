<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Client;
use App\DailyQuestion;
use Carbon\Carbon;

class CreateDailyQuestionLogger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CreateDailyQuestionLogger:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate for each active client CreateDailyQuestionLogger';

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
}
