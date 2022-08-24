<?php

namespace App\Policies;

use App\Client;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Client $client){

        error_log('called clientpolicy view');
        return $user->id == $client->user_id;

    }

    public function update(User $user, Client $client){

        error_log('called clientpolicy update');
        return $user->id == $client->user_id;

    }
}


// Controller Method	Policy Method
// index	viewAny
// show	view
// create	create
// store	create
// edit	update
// update	update
// destroy	delete