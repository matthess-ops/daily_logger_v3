<?php

namespace App\Http\Controllers;

use App\DailyQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyQuestionController extends Controller
{
    // return view with the last 5 days of daily questions questionaires for user_id
    // only client
    public function index($user_id)
    {
        error_log("DailyQuestionController@index called");

            $dailyQuestions = DailyQuestion::where('user_id', $user_id)->orderBy('created_at','DESC') // sort to put the latest dailyActivity on top
            ->take(5) // 5 days
            ->get();
            $this->authorize('viewAny', $dailyQuestions->first());

        return view('web.sections.client.daily_questions.index',['dailyQuestions'=>$dailyQuestions]);



    }


    //return the view with the DailyQuestion of interest.
    //only access for cient
    public function edit($user_id,$daily_question_id)
    {
        error_log('DailyQuestionController@edit called');

        $dailyQuestions = DailyQuestion::find($daily_question_id);
        $this->authorize('update', $dailyQuestions);

        return view('web.sections.client.daily_questions.edit',compact('dailyQuestions'));
    }

    //update the the old scores with the new scores
    //only client
    public function update(Request $request, $user_id,$daily_question_id)
    {
        error_log('DailyQuestionController@update called');

        $validatedData = $request->validate([
            'scores' => 'required|array',

        ]);
        $dailyQuestion = DailyQuestion::find($daily_question_id);
        $this->authorize('update', $dailyQuestion);
        $dailyQuestion->scores = array_map('intval',$request->input('scores'));

        // $dailyQuestion->scores = $request->input('scores');
        $dailyQuestion->save();
        return redirect()->back();
    }


}
