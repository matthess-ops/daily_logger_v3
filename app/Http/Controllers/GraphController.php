<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use App\DailyActivity;
use App\DailyQuestion;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Gate;

class GraphController extends Controller
{

    public function index($user_id)
    {
        $dailyActivities = DailyActivity::where('user_id', $user_id)->get();
        $dailyQuestions = DailyQuestion::where('user_id', $user_id)->get();
        if ($dailyQuestions->isNotEmpty() && $dailyActivities->isNotEmpty()) {
            $this->authorize('isClientDailyQuestionOwner', $dailyQuestions[0]);
            $this->authorize('isClientDailyActivityOwner', $dailyActivities[0]);
        }


        return view('web.sections.graph.index', ['dailyQuestions' => $dailyQuestions, 'dailyActivities' => $dailyActivities]);
    }




    // public function activities($user_id)
    // {
    //     error_log($user_id);
    //     $dailyActivities = DailyActivity::where('user_id', $user_id)->get();
    //     $this->authorize('isClientDailyActivityOwner', $dailyActivities[0]);


    //     return view('web.sections.graph.activities', ['dailyActivities' => $dailyActivities]);
    // }

    // public function dailyreportsgraph($user_id)
    // {
    //     $dailyQuestions = DailyQuestion::where('user_id', $user_id)->get()->makeHidden(['mentor_scores', 'mentor_id', 'mentor_filled_at', 'mentor_filled']);
    //     $this->authorize('isClientDailyQuestionOwner', $dailyQuestions[0]);

    //     return view('web.sections.graph.dailyReports', ['dailyQuestions' => $dailyQuestions]);
    // }

    public function mentordailyreportsgraph($user_id)
    {


        $this->authorize('isMentor');
        $dailyActivities = DailyActivity::where('user_id', $user_id)->get();
        $dailyQuestions = DailyQuestion::where('user_id', $user_id)->get();
        return view('web.sections.graph.mentordailygraph', ['dailyQuestions' => $dailyQuestions, 'dailyActivities' => $dailyActivities]);
    }
}
