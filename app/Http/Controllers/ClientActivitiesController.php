<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

//authorization consideration: since only the client needs to have the ability to crud
//its own data. It was decided in each function to use the Auth plus db relationships to retrieve
//the needed data. This way an user can only retrieve its own data.



//controller that is responsible for storing and deleting main and scaled activities
//for an particular client.
class ClientActivitiesController extends Controller
{
    //return a view with the activities associated with the currently logged in user.
    public function index()
    {
        error_log('ClientActivitiesController@index called');

        $clientActivities = Auth::user()->client->activities->sortByDesc('created_at'); // sort for created_at to put the latest on top
        $this->authorize('viewAny', $clientActivities[0]);

        return view('web.sections.client.activities.index', ['activities' => $clientActivities  ]);
    }


    public function create()
    {
        //
    }

    //validate and store a main or scaled activity to the activities table.
    //since main and scaled activities inputs use the the same form, you will
    //need to check if the input is an mainActivity or a scaledActivity
    public function store(Request $request)
    {
        error_log('ClientActivitiesController@store called');
        //check if the $request has an mainActivity input field
        if ($request->has('mainActivity')) {
            // validate the mainAcitivit input
            $validatedData = $request->validate([
                'mainActivity' => 'required',

            ]);
            Activity::create([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => Auth::id(),
                'value' => $request->input('mainActivity'),
                'type' => 'main',
            ]);
        }
        //check if the $request has an scaledActivity input field
        if ($request->has('scaledActivity')) {

            $validatedData = $request->validate([
                'scaledActivity' => 'required',

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
    //Destroy a main or scaled activity.
    public function destroy(Request $request)
    {

        $activityToRemove = $request->input('removeActivity');
        $activity = Activity::find($activityToRemove);
        $this->authorize('delete-activity', $activity);
        $activity->delete();
        return redirect()->back();
    }
}
