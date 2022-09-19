<?php

namespace App\Http\Controllers;

use App\Mentor;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;



class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        error_log('MentorController@index');
        error_log(json_encode($request->all()));


        error_log("check search " . $request->input('search'));
        $search = $request->input('search');
        $mentors = Mentor::paginate(10);
        $mentors = Mentor::with('user')
            ->where('firstname', 'LIKE', "%{$search}%")
            ->orWhere('lastname', 'LIKE', "%{$search}%")
            ->paginate(10);
        return view('web.sections.admin.mentor.index', compact('mentors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        error_log('MentorController@create');

        return view('web.sections.admin.mentor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Mentor::class);

        error_log('MentorController@store called');
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
        $user->role = 'mentor';
        $user->active = true;
        $user->save();


        $mentor = new Mentor();
        $mentor->firstname = $request->input('firstname');
        $mentor->user_id = $user->id;

        $mentor->lastname = $request->input('lastname');
        $mentor->street = $request->input('street');
        $mentor->street_nr = $request->input('street_nr');
        $mentor->city = $request->input('city');
        $mentor->postcode = $request->input('postcode');
        $mentor->phone_number = $request->input('phone_number');

        $mentor->save();
        return Redirect::route('mentor.show', ['mentor_id' => $mentor->id]);
        // return view('web.sections.admin.client.show', compact('client'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($mentor_id)
    {
        error_log('MentorController@show');

        $mentor = Mentor::find($mentor_id);
        $this->authorize('view', $mentor);
        if (Auth::user()->isAdmin()) {
            return view('web.sections.admin.mentor.show', compact('mentor'));
        } elseif (Auth::user()->ismentor()) {
            return view('web.sections.mentor.show', compact('mentor'));
        }


        // return view('web.sections.admin.mentor.show');

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
    public function update(Request $request, $mentor_id)
    {
        error_log('mentor.update called');
        $mentor = Mentor::find($mentor_id);
        $this->authorize('update', $mentor);
        //user data is needed because this model contains the email address.
        $user = User::find($mentor->user_id);

        if (Auth::user()->ismentor()) {
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
            //the updated mentor data
            $mentor->firstname = $request->input('firstname');
            $mentor->lastname = $request->input('lastname');
            $mentor->street = $request->input('street');
            $mentor->street_nr = $request->input('street_nr');
            $mentor->city = $request->input('city');
            $mentor->postcode = $request->input('postcode');
            $mentor->phone_number = $request->input('phone_number');

            $mentor->save();
            // the update user/mentor email
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
