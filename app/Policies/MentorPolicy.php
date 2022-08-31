<?php

namespace App\Policies;

use App\Mentor;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MentorPolicy
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
        error_log('mentor policy before called');
        if ($user->role == 'admin') {
            return true;
        }
    }

        public function view(User $user, Mentor $client){

            error_log('called mentor policy view');
            return $user->id == $client->user_id;

        }

        public function create(User $user){

            error_log('called MentorPolicy view');
            return $user->isAdmin();

        }

        public function update(User $user, Mentor $mentor){

            error_log('called MentorPolicy update');
            return $user->id == $mentor->user_id;

        }
}
