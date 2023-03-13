<?php

namespace App\Http\Controllers;

use App\Client;
use App\Question;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Activity;


class ClientController extends Controller
{
    //return view with paginated search results for clients.
    // only admin accessable.
    public function index(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $this->authorize('isAdmin');
            $search = $request->input('search');
            $clients = Client::paginate(10);
            $clients = Client::with('user')
                ->where('firstname', 'LIKE', "%{$search}%")
                ->orWhere('lastname', 'LIKE', "%{$search}%")
                ->paginate(10);
            return view('web.sections.admin.client.index', compact('clients'));
        }

        if (Auth::user()->isMentor()) {
            $this->authorize('isMentor');
            $search = $request->input('search');
            $clients = Client::paginate(10);
            $clients = Client::with('user')
                ->where('firstname', 'LIKE', "%{$search}%")
                ->orWhere('lastname', 'LIKE', "%{$search}%")
                ->paginate(10);
            return view('web.sections.admin.client.index', compact('clients'));
        }
        if (Auth::user()->isClient()) {
           abort(403);
        }


    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // return the view to create an new client.
    //only admin
    public function create()
    {
        $this->authorize('isAdmin');

        return view('web.sections.admin.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //store a new client
    //only admin access
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        error_log('ClientController@store called');
        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'street' => 'required',
            'street_nr' => 'required',

            'postcode' => 'required',
            'phone_number' => 'required',
            'city' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->input('firstname');

        // $user->name = Crypt::encryptString($request->input('firstname'));
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->role = 'client';
        $user->active = true;
        $user->save();


        $client = new Client();
        $client->firstname = $request->input('firstname');
        $client->user_id = $user->id;

        $client->lastname = $request->input('lastname');
        $client->street = $request->input('street');
        $client->street_nr = $request->input('street_nr');
        $client->city = $request->input('city');
        $client->postcode = $request->input('postcode');
        $client->phone_number = $request->input('phone_number');

        $client->save();

        //add the default daily question for client

        $defaultQuestions =  Question::where('user_id', Auth::id())->get(); //get the admin default questions
        foreach ($defaultQuestions as $defaultquestion) {
            $newQuestion = new Question();
            $newQuestion->user_id = $user->id;
            $newQuestion->question = $defaultquestion->question;
            $newQuestion->save();
        }

        //add number of default activities for client
        $defaultMainActivities = ["werken", "rusten", "ontspanning"];
        foreach ($defaultMainActivities as $defaulMainActivity) {
            Activity::create([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => $user->id,
                'value' => $defaulMainActivity,
                'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),

                'type' => 'main',
            ]);

            
        }
        $defaultScaledActivities = ["Stress", "Vol hoofd", "concentratie"];

        foreach ($defaultScaledActivities as $defaultScaledActivity) {
            Activity::create([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => $user->id,
                'value' => $defaultScaledActivity,
                'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),

                'type' => 'scaled',
            ]);
        }


        // return Redirect::route('client.show', ['client_id' => $user->id]);
        return view('web.sections.admin.client.show', compact('client'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //return a view with the associated client data
    //only user and admin
    public function show($id)
    {
        $client = Client::find($id);
        // dd($id);


        if (Auth::user()->isAdmin()) {
            $this->authorize('isAdmin');
            error_log("clientcontroller isadmin");
            // return Redirect::route('client.show', ['client_id' => $id]);

            return view('web.sections.admin.client.show', compact('client'));
        } elseif (Auth::user()->isClient()) {
            $client = Auth::user()->client;
            // dd($client);
            // $this->authorize('isClientUser', $client);

            return view('web.sections.client.show', compact('client'));
        } elseif (Auth::user()->isMentor()) {
            $this->authorize('isMentor');

            return view('web.sections.mentor.client.show', compact('client'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // return client data
    // only user
    public function edit($id)
    {
        error_log("client.edit called");
        $client = Client::find($id);
        $this->authorize('isClientUser', $client);

        return view('web.sections.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //validate and update client data.
    public function update(Request $request, $client_id)
    {
        error_log('client.update called');
        $client = Client::find($client_id);
        //user data is needed because this model contains the email address.
        $user = User::find($client->user_id);

        if (Auth::user()->isClient()) {
            $this->authorize('isClientUser', $client);

            $validatedData = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id, 'id')
                ],            'street' => 'required',
                'street_nr' => 'required',
                'street' => 'required',

                'postcode' => 'required',
                'phone_number' => 'required',
                'city' => 'required',
            ]);
            //the updated client data
            $client->firstname = $request->input('firstname');
            $client->lastname = $request->input('lastname');
            $client->street = $request->input('street');
            $client->street_nr = $request->input('street_nr');
            $client->city = $request->input('city');
            $client->postcode = $request->input('postcode');
            $client->phone_number = $request->input('phone_number');

            $client->save();
            // the update user/client email
            $user->email = $request->input('email');

            $user->save();
            return view('web.sections.client.show', compact('client'));
        } elseif (Auth::user()->isAdmin()) {
            $this->authorize('isAdmin', $client);

            if ($user->active == true) {
                $user->active = false;
            } else {
                $user->active = true;
            }
            $user->save();

            return view('web.sections.admin.client.show', compact('client'));;
        }
    }
}
