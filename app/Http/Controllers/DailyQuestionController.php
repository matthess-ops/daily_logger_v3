<?php

namespace App\Http\Controllers;

use App\DailyQuestion;
use Illuminate\Http\Request;

class DailyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        error_log("DailyQuestionController@index called");
        $dailyQuestions = DailyQuestion::where('user_id', $user_id)->orderBy('created_at','DESC') // sort to put the latest dailyActivity on top
            ->take(5) // 5 days
            ->get();

        // $this->authorize('viewAny', $dailyActivities[0]);


        // return view('web.sections.client.daily_activities.index',['dailyActivities'=>$dailyActivities]);
        return view('web.sections.client.daily_questions.index',['dailyQuestions'=>$dailyQuestions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id,$daily_question_id)
    {
        error_log('DailyQuestionController@edit called');
        $dailyQuestions = DailyQuestion::find($daily_question_id);

        return view('web.sections.client.daily_questions.edit',compact('dailyQuestions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id,$daily_question_id)
    {
        error_log('DailyQuestionController@update called');
        // dd($request->all());
        $validatedData = $request->validate([
            'firstname' => 'required|array',
          
        ]);
        $dailyQuestion = DailyQuestion::find($daily_question_id);
        $dailyQuestion->scores = $request->input('scores');
        $dailyQuestion->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
