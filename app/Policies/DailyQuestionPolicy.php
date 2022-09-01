<?php

namespace App\Policies;

use App\DailyQuestion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyQuestionPolicy
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

    public function viewAny(User $user, DailyQuestion $dailyQuestion){

        return $user->id == $dailyQuestion->user_id;

    }

    public function update(User $user, DailyQuestion $dailyQuestion){

        return $user->id == $dailyQuestion->user_id;

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


