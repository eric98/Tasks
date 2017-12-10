<?php

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

// middleware => 'auth', vol dir que has d'estar loguejat
Route::group(['middleware' => 'auth'], function () {

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    //adminlte_routes
    Route::get('tasks_php', 'TaskController@index');
    Route::get('tasks_php/create', 'TaskController@create');
    Route::get('tasks_php/edit/{task}', 'TaskController@edit');
    Route::get('tasks_php/{task}', 'TaskController@show');
    Route::post('tasks_php', 'TaskController@store');
    Route::put('tasks_php/{task}', 'TaskController@update');
    Route::get('/tasks_php/statuschance/{task}', 'TaskController@complete');
    Route::delete('tasks_php/{task}', 'TaskController@destroy');

    //PURE JAVASCRIPT
    Route::view('/tasks', 'tasks');
    Route::view('/tokens', 'tokens');
});
