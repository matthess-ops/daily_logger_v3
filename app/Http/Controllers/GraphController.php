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

        public function index($user_id){
        $dailyActivities = DailyActivity::where('user_id', $user_id)->get();
        $dailyQuestions = DailyQuestion::where('user_id', $user_id)->get();
        return view('web.sections.graph.index', ['dailyQuestions' => $dailyQuestions,'dailyActivities'=>$dailyActivities]);
    }


    // public function index(Request $request, $user_id)
    // {
    //     error_log('GraphController@index called');
    //     error_log(json_encode($request->all()));
    //     if ($request->has('startDate') and $request->has('endDate')) {
    //         error_log('has start and end date check if valid');

    //         $validatedData = $request->validate([
    //             'startDate' => 'required|date|',
    //             'endDate' => 'required|date|after:startDate',

    //         ]);
    //         if ($request->input('action') === "logger") {
    //             $dailyActivities = DailyActivity::where('user_id', $user_id)->whereBetween('created_at', [$request->input('startDate'), $request->input('endDate')])->get();
    //             return view('web.sections.graph.index',['dailyActivities'=>$dailyActivities,'backStartDate'=>$request->input('startDate'),'backEndDate'=>$request->input('endDate')]);
    //         }
    //         if ($request->input('action') === "daily") {
    //         }

    //         return view('web.sections.graph.index');
    //     } else {

    //         error_log('does not start and end date');

    //         return view('web.sections.graph.index');
    //     }
    // }


    public function activities($user_id)
    {
        error_log("GraphController@activities called");
        error_log($user_id);
        $dailyActivities = DailyActivity::where('user_id', $user_id)->get();
        $this->authorize('isClientDailyActivityOwner', $dailyActivities[0]);

        // $mainActivities = Activity::where('user_id',$user_id)->where('type','main')->get();
        // $scaledActivities = Activity::where('user_id',$user_id)->where('type','scaled')->get();

        return view('web.sections.graph.activities', ['dailyActivities' => $dailyActivities]);
    }

    public function dailyreportsgraph($user_id)
    {
        error_log('graphcontroller dailyreport called');
        $dailyQuestions = DailyQuestion::where('user_id', $user_id)->get()->makeHidden(['mentor_scores', 'mentor_id', 'mentor_filled_at', 'mentor_filled']);
        $this->authorize('isClientDailyQuestionOwner', $dailyQuestions[0]);

        return view('web.sections.graph.dailyReports', ['dailyQuestions' => $dailyQuestions]);
    }

    public function mentordailyreportsgraph($user_id)
    {


        error_log("called mentordailyreportsgraph " . $user_id);
        $this->authorize('isMentor');
        $dailyQuestions = DailyQuestion::where('user_id', $user_id)->get();


        return view('web.sections.graph.mentordailygraph', ['dailyQuestions' => $dailyQuestions]);
    }
}
