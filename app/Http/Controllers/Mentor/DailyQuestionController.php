<?php

namespace App\Http\Controllers\Mentor;

use App\DailyQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DailyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('web.sections.test.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($question_id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($question_id)
    {

        $dailyQuestions = DailyQuestion::findOrFail($question_id);

        return view('web.sections.mentor.daily_questions.edit',['dailyQuestions'=>$dailyQuestions]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $question_id)
    {
        // dd($request->all());
      error_log('Mentor.DailyQuestions@update called');
      $validatedData = $request->validate([
        'scores' => 'required|array',

    ]);
    $dailyQuestion = DailyQuestion::findOrFail($question_id);
    $dailyQuestion->mentor_scores = array_map('intval',$request->input('scores'));

    // $dailyQuestion->scores = $request->input('scores');
    $dailyQuestion->save();
      return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
