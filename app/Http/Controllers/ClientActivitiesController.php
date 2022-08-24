<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ClientActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        error_log('ClientActivitiesController@index called');

        $clientActivities = Auth::user()->client->activities->sortByDesc('created_at');
        return view('web.sections.client.activities.index', ['activities' => $clientActivities  ]);
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
        error_log('ClientActivitiesController@store called');

        
    
        if ($request->has('mainActivity')) {

            $validatedData = $request->validate([
                'mainActivity' => 'required|min:6',
           
            ]);
            Activity::create([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => Auth::id(),
                'value' => $request->input('mainActivity'),
                'type' => 'main',
            ]);
        }

        if ($request->has('scaledActivity')) {

            $validatedData = $request->validate([
                'scaledActivity' => 'required|min:6',
           
            ]);
            Activity::create([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => Auth::id(),
                'value' => $request->input('scaledActivity'),
                'type' => 'scaled',
            ]);
        } 

        return redirect()->back();
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
    public function destroy(Request $request)
    {

        $activityToRemove = $request->input('removeActivity');
        Activity::destroy($activityToRemove);
        return redirect()->back();
    }
}
