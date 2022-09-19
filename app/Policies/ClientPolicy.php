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

    public function before(User $user)
{
    error_log('clientpolicy before called');
    if ($user->role == 'admin') {
        return true;
    }
}

    public function view(User $user, Client $client){

        error_log('called clientpolicy view');
        return $user->id == $client->user_id;

    }

    public function create(User $user){

        error_log('called clientpolicy view');
        return $user->isAdmin();

    }

   

    public function viewAny(User $user){

        error_log('called clientpolicy viewAny');
        return $user->isAdmin();

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
