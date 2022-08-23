<?php

use App\Client;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            //dummy questions
            $questions = ["Hoe was je dag,", "Hoe gespannen was je.", "Was je erg nerveus", "Was je erg anstig", "Hoeveel pijn had je vandaag", "Was je er erg druk in je hoofd", "Had je veel pijn"];
            //random number of questions to save to the db for this client
            $numOfQuestions =  rand(0, count($questions));
            for ($i = 0; $i < $numOfQuestions; $i++) {

                $randomQuestionIndex = rand(0, count($questions) - 1);
                $randomQuestion = $questions[$randomQuestionIndex];
                //remove the the question from the questions array, needed because else the possibility exists that the same questions get picked randomly.
                array_splice($questions,$randomQuestionIndex,1);
                //save the questions to the database
                Question::create([
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'user_id' => $client->user_id,
                    'question' => $randomQuestion,
                ]);
            }
        }
    }
}
