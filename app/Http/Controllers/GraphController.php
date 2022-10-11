<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use App\DailyActivity;
class GraphController extends Controller
{


    public function activities($user_id)
    {
        error_log("GraphController@activities called");
        error_log($user_id);
        $dailyActivities = DailyActivity::where('user_id',$user_id)->get();
        $mainActivities = Activity::where('user_id',$user_id)->where('type','main')->get();
        $scaledActivities = Activity::where('user_id',$user_id)->where('type','scaled')->get();

        return view('web.sections.graph.activities',['dailyActivities'=>$dailyActivities,'mainActivities'=>$mainActivities,'scaledActivities'=>$scaledActivities]);

    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function edit($id)
    {
        //
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
