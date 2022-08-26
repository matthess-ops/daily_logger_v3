<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\DailyActivity;

class DailyActivityPolicy
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

    public function viewAny(User $user,DailyActivity $dailyActivity){

        error_log('called DailyActivity viewAny');
        return $user->id == $dailyActivity->user_id;

    }

    public function update(User $user,DailyActivity $dailyActivity){

        error_log('called DailyActivity update');
        return $user->id == $dailyActivity->user_id;

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
