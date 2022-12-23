<?php

namespace App\Http\Controllers\Mentor;

use App\DailyQuestion;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('isMentor', Client::class);
        $search = $request->input('search');

        $dailyQuestions = DailyQuestion::where('mentor_filled', false)


            ->with('client')
            ->whereHas('client', function ($query) use ($search) {
                $query->where('firstname', 'like', '%' . $search . '%')            // ->orWhere('lastname', 'LIKE', "%{$search}%")
                    ->orWhere('lastname', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('created_at', 'DESC')

            ->get();




        return view('web.sections.mentor.daily_questions.index', ['dailyQuestions' => $dailyQuestions, 'searchQuery'=>$search]);
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
        $this->authorize('isMentor');

        $dailyQuestions = DailyQuestion::findOrFail($question_id);

        return view('web.sections.mentor.daily_questions.edit', ['dailyQuestions' => $dailyQuestions]);
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
        $this->authorize('isMentor');

        $validatedData = $request->validate([
            'mentorScores' => 'required|array',
            'mentorScores.*' => 'int',
            'mentorRemark'=> 'nullable|string|max:500',


        ]);
        $dailyQuestion = DailyQuestion::findOrFail($question_id);
        $dailyQuestion->mentor_scores = array_map('intval', $request->input('mentorScores'));
        $dailyQuestion->mentor_filled = true;
        $dailyQuestion->mentor_filled_at = Carbon::now();
        $dailyQuestion->mentor_id = Auth::id();
        $dailyQuestion->mentor_remark= $request->input('mentorRemark');
        // error_log($request->input('mentor_remark'))

        // $dailyQuestion->scores = $request->input('scores');
        $dailyQuestion->save();
        return redirect()->route('mentor.dailyquestion.index');
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
