<?php

namespace App\Http\Controllers;

use App\Activity;
use App\DailyActivity;
use App\User;
use Illuminate\Http\Request;

class DailyActivityController extends Controller
{
    //return a view with the client latest 5 days of daily activity entries from the dailyActivitie table
    public function index($user_id)
    {
        error_log('DailyActivityController@index called');
        $dailyActivities = DailyActivity::where('user_id', $user_id)->orderBy('created_at') // sort to put the latest dailyActivity on top
            ->take(5) // 5 days
            ->get()
            ->makeHidden(['time_slots', 'main_activities','scaled_activities','scaled_activities_scores']); // not all data is needed for the view to function

        $this->authorize('viewAny', $dailyActivities[0]);


        return view('web.sections.client.daily_activities.index',['dailyActivities'=>$dailyActivities]);
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

    //return a view for the specified client  and daily activity.
    public function edit($user_id, $daily_activity_id)
    {
        error_log('DailyActivityController@edit called');
        $dailyActivityResults = DailyActivity::find($daily_activity_id);
        $activities = User::find($user_id)->client->activities;
        $this->authorize('update', $dailyActivityResults);

        return view('web.sections.client.daily_activities.edit',compact('dailyActivityResults','activities'));
    }

    //update the daily activity of interest with the new inputs.
    public function update(Request $request, $user_id,$daily_activity_id)
    {
        error_log('DailyActivityController@update called');

        $mainActivityValue = Activity::find($request->input('main'))->value;
        $mainActivityColor = Activity::find($request->input('main'))->color;
        $dailyActivity = DailyActivity::find($daily_activity_id);
        $this->authorize('update', $dailyActivity);

        $scaledActivitiesScores = $request->input('scaled');
        $checkBoxesOn = $request->input('boxOn'); // checkboxes input
        //cannot modify/update the dailyActivity directly because of an Indirect modification of overloaded property erro
        $newMainActivities = $dailyActivity->main_activities;
        $newColors = $dailyActivity->colors;
        $newScaledActivitiesScores = $dailyActivity->scaled_activities_scores;


        if($request->has('boxOn')){
            //foreach checkbox in the checkboxesOn array update the data in the needed array
            foreach ($checkBoxesOn as $checkBoxOn) {
                $newMainActivities[$checkBoxOn] = $mainActivityValue;
                $newColors[$checkBoxOn]= $mainActivityColor;
                $newScaledActivitiesScores[$checkBoxOn]= $scaledActivitiesScores;

            }
            $dailyActivity->main_activities = $newMainActivities;
            $dailyActivity->scaled_activities_scores=$newScaledActivitiesScores;
            $dailyActivity->colors = $newColors;
            $dailyActivity->save();
        }

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
