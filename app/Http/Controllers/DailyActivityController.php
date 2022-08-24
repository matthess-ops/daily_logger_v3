<?php

namespace App\Http\Controllers;

use App\DailyActivity;
use Illuminate\Http\Request;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        error_log('DailyActivityController@index called');
        error_log('user_id ' . $user_id);
        $dailyActivities = DailyActivity::where('user_id', $user_id)->orderBy('created_at')
            ->take(5)
            ->get()
            ->makeHidden(['time_slots', 'main_activities','scaled_activities','scaled_activities_scores']);

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id, $daily_activity_id)
    {
        error_log('DailyActivityController@edit called');
        return view('web.sections.client.daily_activities.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
