<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Activity;
use App\Policies\ClientActivitiesPolicy;
use app\DailyActivity;
use App\DailyQuestion;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Activity::class => ClientActivitiesPolicy::class,
        // Client::class => ClientPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('clientNotAllowed', function (User $user) {

            if($user->role ==='client'){
                error_log("client not allowed");
                return false;
            }else{
                error_log("continue");
                return true;
            }
        });

        Gate::define('isClient', function (User $user) {

            return $user->role ==='client';
        });
        Gate::define('isAdmin', function (User $user) {
            return $user->role ==='admin';
        });

        Gate::define('isMentor', function (User $user) {
            return $user->role ==='mentor';
        });

        Gate::define('delete-activity', function (User $user, Activity $activity) {
            error_log("delete-activity gate called ".$activity->user_id.$user->id);
            return $user->id == $activity->user_id;

        });

        Gate::define('isClientDailyActivityOwner', function (User $user, DailyActivity $dailyActivity) {
            error_log('isClientDailyActivityOwner gate called');
            return $user->id ==$dailyActivity->user_id;
        });

        Gate::define('isClientDailyQuestionOwner', function (User $user, DailyQuestion $dailyQuestion) {
            error_log('isClientDailyQuestionOwner gate called');
            return $user->id ==$dailyQuestion->user_id;
        });


    }
}
