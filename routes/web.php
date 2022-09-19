<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('client/{id}/show', 'ClientController@show')->name('client.show');



Route::group(['prefix' => 'client'], function() {

    Route::get('/', 'ClientController@index')->name('client.index')->middleware('auth');
    Route::get('/create', 'ClientController@create')->name('client.create')->middleware('auth');
    Route::post('/create', 'ClientController@store')->name('client.store')->middleware('auth');
    Route::get('/{client_id}/show', 'ClientController@show')->name('client.show')->middleware('auth');
    Route::patch('/{client_id}/update', 'ClientController@update')->name('client.update')->middleware('auth');
    Route::delete('/{id}/delete', 'ClientController@destroy')->name('client.destroy')->middleware('auth');
    Route::get('/{client_id}/edit', 'ClientController@edit')->name('client.edit')->middleware('auth');
});


// Route::group(['prefix' => 'client'], function() {

//     Route::get('/', 'ClientController@index')->name('client.index')->middleware('auth');
//     Route::get('/create', 'ClientController@create')->name('client.create')->middleware('auth');
//     Route::post('/create', 'ClientController@store')->name('client.store')->middleware('auth');
//     Route::get('/{client_id}/show', 'ClientController@show')->name('client.show')->middleware('auth');
//     Route::patch('/{client_id}/update', 'ClientController@update')->name('client.update')->middleware('auth');
//     Route::delete('/{id}/delete', 'ClientController@destroy')->name('client.destroy')->middleware('auth');
//     Route::get('/{client_id}/edit', 'ClientController@edit')->name('client.edit')->middleware('auth');
// });


Route::group(['prefix' => 'client/activities'], function() {
    Route::get('/', 'ClientActivitiesController@index')->name('clientActivities.index')->middleware('auth');
    Route::post('/create', 'ClientActivitiesController@store')->name('clientActivities.store')->middleware('auth');
    Route::delete('/deletee', 'ClientActivitiesController@destroy')->name('clientActivities.destroy')->middleware('auth');
});


Route::group(['prefix' => 'client/daily-activity'], function() {

    Route::get('{user_id}/', 'DailyActivityController@index')->name('dailyActivity.index')->middleware('auth');
    Route::get('{user_id}/create', 'DailyActivityController@create')->name('dailyActivity.create')->middleware('auth');
    Route::post('{user_id}/create', 'DailyActivityController@store')->name('dailyActivity.store')->middleware('auth');
    Route::get('{user_id}/{daily_activity_id}/show', 'DailyActivityController@show')->name('dailyActivity.show')->middleware('auth');
    Route::patch('{user_id}/{daily_activity_id}/update', 'DailyActivityController@update')->name('dailyActivity.update')->middleware('auth');
    Route::delete('{user_id}/{daily_activity_id}/delete', 'DailyActivityController@destroy')->name('dailyActivity.destroy')->middleware('auth');
    Route::get('{user_id}/{daily_activity_id}/edit', 'DailyActivityController@edit')->name('dailyActivity.edit')->middleware('auth');
});

Route::group(['prefix' => 'client/daily-question'], function() {

    Route::get('{user_id}/', 'DailyQuestionController@index')->name('dailyQuestion.index')->middleware('auth');
    Route::get('{user_id}/create', 'DailyQuestionController@create')->name('dailyQuestion.create')->middleware('auth');
    Route::post('{user_id}/create', 'DailyQuestionController@store')->name('dailyQuestion.store')->middleware('auth');
    Route::get('{user_id}/{daily_question_id}/show', 'DailyQuestionController@show')->name('dailyQuestion.show')->middleware('auth');
    Route::patch('{user_id}/{daily_question_id}/update', 'DailyQuestionController@update')->name('dailyQuestion.update')->middleware('auth');
    Route::delete('{user_id}/{daily_question_id}/delete', 'DailyQuestionController@destroy')->name('dailyQuestion.destroy')->middleware('auth');
    Route::get('{user_id}/{daily_question_id}/edit', 'DailyQuestionController@edit')->name('dailyQuestion.edit')->middleware('auth');
});

Route::group(['prefix' => 'mentor'], function() {

    Route::get('/', 'MentorController@index')->name('mentor.index')->middleware('auth');
    Route::get('/create', 'MentorController@create')->name('mentor.create')->middleware('auth');
    Route::post('/create', 'MentorController@store')->name('mentor.store')->middleware('auth');
    Route::get('/{mentor_id}/show', 'MentorController@show')->name('mentor.show')->middleware('auth');
    Route::patch('/{mentor_id}/update', 'MentorController@update')->name('mentor.update')->middleware('auth');
    Route::delete('/{mentor_id}/delete', 'MentorController@destroy')->name('mentor.destroy')->middleware('auth');
    Route::get('/{mentor_id}/edit', 'MentorController@edit')->name('mentor.edit')->middleware('auth');
});

Route::group(['prefix' => 'question'], function() {

    Route::get('/', 'QuestionController@index')->name('question.index')->middleware('auth');
    Route::get('/create', 'QuestionController@create')->name('question.create')->middleware('auth');
    Route::post('{user_id}/create', 'QuestionController@store')->name('question.store')->middleware('auth');
    Route::get('/{question_id}/show', 'QuestionController@show')->name('question.show')->middleware('auth');
    Route::patch('/{user_id}/update', 'QuestionController@update')->name('question.update')->middleware('auth');
    Route::delete('/{question_id}/delete', 'QuestionController@destroy')->name('question.destroy')->middleware('auth');
    Route::get('/{client_id}/edit', 'QuestionController@edit')->name('question.edit')->middleware('auth');
});


Route::group(['prefix' => 'defaultquestion'], function() {

    // Route::get('/', 'DefaultQuestionController@index')->name('defaultquestion.index')->middleware('auth');
    // Route::get('/create', 'DefaultQuestionController@create')->name('defaultquestion.create')->middleware('auth');
    Route::post('/create', 'DefaultQuestionController@store')->name('defaultquestion.store')->middleware('auth');
    // Route::get('/{DefaultQuestion_id}/show', 'DefaultQuestionController@show')->name('defaultquestion.show')->middleware('auth');
    // Route::patch('/{user_id}/update', 'DefaultQuestionController@update')->name('defaultquestion.update')->middleware('auth');
    Route::delete('/{defaulquestion_id}/delete', 'DefaultQuestionController@destroy')->name('defaultquestion.destroy')->middleware('auth');
    Route::get('/edit', 'DefaultQuestionController@edit')->name('defaultquestion.edit')->middleware('auth');
});
