<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      // fix authorization
        error_log(json_encode($request->all()));
        error_log('ClientController@index');

     
            error_log("check search ".$request->input('search'));
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

    //return a view with the associated client data
    public function show($id)
    {
        error_log("client.show called");
        $client = Client::find($id);
        $this->authorize('view', $client);
        return view('web.sections.client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // return client data
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
    public function update(Request $request, $id)
    {
        error_log('client.update called');
        $client = Client::find(Auth::id());
        $this->authorize('update', $client);
        //user data is needed because this model contains the email address.
        $user = User::find($client->user_id);

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
