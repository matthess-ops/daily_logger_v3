<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    //return view with paginated search results for clients.
    // only admin accessable.
    public function index(Request $request)
    {
        error_log('ClientController@index called');
        $this->authorize('viewAny',Client::class);
        $search = $request->input('search');
        $clients = Client::paginate(10);
        $clients = Client::with('user')
            ->where('firstname', 'LIKE', "%{$search}%")
            ->orWhere('lastname', 'LIKE', "%{$search}%")
            ->paginate(10);
        return view('web.sections.admin.client.index', compact('clients'));
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
        $this->authorize('create',Client::class);

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
        $this->authorize('create');

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
        return Redirect::route('client.show', ['client_id' => $client->id]);
        // return view('web.sections.admin.client.show', compact('client'));
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
        error_log("client.show called");
        $client = Client::find($id);
        $this->authorize('view', $client);
        if (Auth::user()->isAdmin()) {
            return view('web.sections.admin.client.show', compact('client'));
        } elseif (Auth::user()->isClient()) {
            return view('web.sections.client.show', compact('client'));
        }elseif(Auth::user()->isMentor()){
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
        $this->authorize('update', $client);

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
        $this->authorize('update', $client);
        //user data is needed because this model contains the email address.
        $user = User::find($client->user_id);

        if (Auth::user()->isClient()) {
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
            return redirect()->back();
        } elseif (Auth::user()->isAdmin()) {
            if ($user->active == true) {
                $user->active = false;
            } else {
                $user->active = true;
            }
            $user->save();

            // error_log('admin is logged in');
            return redirect()->back();
        }
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
