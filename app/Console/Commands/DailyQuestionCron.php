<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        error_log("dialy question cron called");
        return 0;
    }
}
