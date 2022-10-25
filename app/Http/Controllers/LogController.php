<?php

namespace App\Http\Controllers;

use App\DailyActivity;
use Auth;
use Illuminate\Http\Request;
use App\DailyQuestion;
use Carbon\Carbon;
use App\Activity;
use app\User;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {

        //         $items = Item::select('*')
        // ->whereBetween('created_at',
        //     [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
        // )
        // ->get();

        // dd($items);

        $dailyQuestions = DailyQuestion::where('user_id', $user_id)->whereBetween(
            'created_at',
            [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
        )
            ->orderBy('created_at', 'DESC')
            ->get();

        $dialyActivities = DailyActivity::where('user_id', $user_id)->whereBetween(
            'created_at',
            [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
        )
            ->orderBy('created_at', 'DESC')
            ->get();

        error_log('logcontroller@index called');
            // dd($dailyQuestions,$dialyActivities);
        return view('web.sections.client.logger.index', ['dailyQuestions' => $dailyQuestions,'dailyActivities'=>$dialyActivities]);
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
    //get today daily_activities and daily_questions and return these
    public function edit($user_id, $date)
    {
        //add authorization
        error_log('date is ' . $date);
        $dailyActivity = DailyActivity::where('user_id', $user_id)->where('date_today', Carbon::parse($date)->format('Y-m-d'))->first();
        $dailyQuestions = DailyQuestion::where('user_id', $user_id)->where('date_today', Carbon::parse($date)->format('Y-m-d'))->first();
        $activities = User::find($user_id)->client->activities;
        return view('web.sections.client.logger.edit', ['dailyActivityResults' => $dailyActivity, 'dailyQuestions' => $dailyQuestions, 'activities' => $activities]);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        error_log("logcontroller@update called");
        error_log(json_encode($request->all()));

        //Activity logger update
        $mainActivityValue = Activity::find($request->input('main'))->value;
        $mainActivityColor = Activity::find($request->input('main'))->color;
        $dailyActivity = DailyActivity::find($request->input('dailyActivityId'));
        // implement authorization here
        //    $this->authorize('update', $dailyActivity);

        $scaledActivitiesScores = array_map('intval', $request->input('scaled'));
        $checkBoxesOn = $request->input('boxOn'); // checkboxes input
        //cannot modify/update the dailyActivity directly because of an Indirect modification of overloaded property erro
        $newMainActivities = $dailyActivity->main_activities;
        $newColors = $dailyActivity->colors;
        $newScaledActivitiesScores = $dailyActivity->scaled_activities_scores;


        if ($request->has('boxOn')) {
            //foreach checkbox in the checkboxesOn array update the data in the needed array
            foreach ($checkBoxesOn as $checkBoxOn) {
                $newMainActivities[$checkBoxOn] = $mainActivityValue;
                $newColors[$checkBoxOn] = $mainActivityColor;
                $newScaledActivitiesScores[$checkBoxOn] = $scaledActivitiesScores;
            }
            $dailyActivity->main_activities = $newMainActivities;
            $dailyActivity->scaled_activities_scores = $newScaledActivitiesScores;
            $dailyActivity->colors = $newColors;
        }
        // check if dailyActivity is completed or started
        $isComplete =  true;
        $isStarted = false;
        foreach ($dailyActivity->main_activities as $mainActivity) {
            if ($mainActivity === null) {
                $isComplete = false;
            }
            if ($mainActivity !== null) {
                $isStarted = true;
            }
        }
        $dailyActivity->completed = $isComplete;
        $dailyActivity->started=$isStarted;
        $dailyActivity->save();





        // save daily question stuff


        $dailyQuestion = DailyQuestion::find($request->input('dailyQuestionId'));
        //    $this->authorize('update', $dailyQuestion);
        $dailyQuestion->scores = array_map('intval', $request->input('scores'));
        if ($request->input('clientRemark') !=  null) {
            $dailyQuestion->client_remark = $request->input('clientRemark');
        }

        //check if dailyQuestion is complete and or started

        $isComplete =  true;
        $isStarted = false;

        $dailyQuestionStarted = false;
        $dailyQuestionCompleted = true;
        foreach ($request->input('scores') as $score) {
            if($score ===null){
                $isComplete = false;
            }
            if($score !==null){
                $isStarted = true;
            }
        }

        $dailyQuestion->started= $isStarted;
        $dailyQuestion->completed = $isComplete;





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
