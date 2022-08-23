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


Route::group(['prefix' => 'client/activities'], function() {

    Route::get('/', 'ClientActivitiesController@index')->name('clientActivities.index')->middleware('auth');
    // Route::get('/create', 'ClientActivitiesController@create')->name('ClientActivities.create')->middleware('auth');
    Route::post('/create', 'ClientActivitiesController@store')->name('clientActivities.store')->middleware('auth');
    // Route::get('/{ClientActivities_id}/show', 'ClientActivitiesController@show')->name('ClientActivities.show')->middleware('auth');
    // Route::patch('/{ClientActivities_id}/update', 'ClientActivitiesController@update')->name('ClientActivities.update')->middleware('auth');
    // Route::delete('/{id}/delete', 'ClientActivitiesController@destroy')->name('clientActivities.destroy')->middleware('auth');
    Route::delete('/deletee', 'ClientActivitiesController@destroy')->name('clientActivities.destroy')->middleware('auth');

    // Route::get('/{ClientActivities_id}/edit', 'ClientActivitiesController@edit')->name('ClientActivities.edit')->middleware('auth');
});
