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


    public function activities($user_id)
    {
        error_log("GraphController@activities called");
        error_log($user_id);
        $dailyActivities = DailyActivity::where('user_id',$user_id)->get();
        $this->authorize('isClientDailyActivityOwner', $dailyActivities[0]);

        // $mainActivities = Activity::where('user_id',$user_id)->where('type','main')->get();
        // $scaledActivities = Activity::where('user_id',$user_id)->where('type','scaled')->get();

        return view('web.sections.graph.activities',['dailyActivities'=>$dailyActivities]);
    }

    public function dailyreportsgraph($user_id){
        error_log('graphcontroller dailyreport called');
        $dailyQuestions = DailyQuestion::where('user_id',$user_id)->get()->makeHidden(['mentor_scores','mentor_id','mentor_filled_at','mentor_filled']);
        $this->authorize('isClientDailyQuestionOwner', $dailyQuestions[0]);

        return view('web.sections.graph.dailyReports',['dailyQuestions'=>$dailyQuestions]);
    }

    public function mentordailyreportsgraph($user_id){


        error_log("called mentordailyreportsgraph ".$user_id);
        $this->authorize('isMentor');
            $dailyQuestions = DailyQuestion::where('user_id',$user_id)->get();


        return view('web.sections.graph.mentordailygraph',['dailyQuestions'=>$dailyQuestions]);

    }


}
