<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//All the questions with the user_id of and admin in the Question table are the default questions.

class DefaultQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    //store a new default question.
    public function store(Request $request)
    {
        error_log('DefaultQuestionController@store');
        $this->authorize('isAdmin');

        $validatedData = $request->validate([
            'defaultQuestion' => 'required',

        ]);

        $newDefaultQuestion = new Question();
        $newDefaultQuestion->user_id = Auth::id();
        $newDefaultQuestion->question = $request->input('defaultQuestion');
        $newDefaultQuestion->save();


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //return the edit view with the default questions
    //only admin
    public function edit()
    {
        $this->authorize('isAdmin');
        error_log('DefaultQuestionController@edit');
        $defaultQuestions = Question::where('user_id', Auth::id())->get();
        return view('web.sections.admin.default_question.edit', compact('defaultQuestions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    //destroy the default question with the defaulquestion_id
    //only admin
    public function destroy($defaulquestion_id)
    {
        $this->authorize('isAdmin');

        error_log('DefaultQuestionController@destory');
        $defaultQuestion =  Question::findOrFail($defaulquestion_id);
        $defaultQuestion->delete();
        return redirect()->back();
    }
}
