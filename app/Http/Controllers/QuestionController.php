<?php

namespace App\Http\Controllers;

use App\Client;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
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
        //
    }

    // store a new question with user_id to the the Question table
    //only admin
    public function store(Request $request, $user_id)
    {
        error_log('QuestionController@store called');
        $this->authorize('isAdmin');
        $validatedData = $request->validate([
            'question' => 'required',

        ]);

        $newQuestion = new Question();
        $newQuestion->user_id = $user_id;
        $newQuestion->question = $request->input('question');
        $newQuestion->save();
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

    //return view with the questions of the client with an id of client_id
    //only admin access
    public function edit($client_id)
    {
        error_log('QuestionController@edit called');
        $this->authorize('isAdmin');

        $client = Client::find($client_id);
        $questions = $client->questions;
        return view('web.sections.admin.client.question.edit', ['questions'=>$questions,'client'=>$client]);
    }

    //update/replace all the questions related to the user_id to the default questions
    //only admin access
    public function update(Request $request, $user_id)
    {
        $this->authorize('isAdmin');

       error_log('QuestionController@update called');
       Question::where('user_id',$user_id)->delete(); // delete all client questions
        $defaultQuestions =  Question::where('user_id',Auth::id())->get(); //get the admin default questions
        foreach ($defaultQuestions as $defaultquestion) {
            $newQuestion = new Question();
            $newQuestion->user_id = $user_id;
            $newQuestion->question= $defaultquestion->question;
            $newQuestion->save();
                }
       return redirect()->back();
    }

    // delete the question with an id of question_id.

    //only admin
    public function destroy($question_id)
    {
        $this->authorize('isAdmin');

        $question = Question::find($question_id);
        $question->delete();
        return redirect()->back();
    }
}
