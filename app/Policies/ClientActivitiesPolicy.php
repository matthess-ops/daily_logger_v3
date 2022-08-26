<?php

namespace App\Policies;

use App\Activity;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientActivitiesPolicy
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

    public function viewAny(User $user,Activity $activity){

        error_log('called ClientActivities viewAny called');
        return $user->id == $activity->user_id;

    }
}
