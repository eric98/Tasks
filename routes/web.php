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
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
    Route::get('task','TaskController@index');
    Route::post('task','TaskController@store');

    Route::get('tasks','TaskController@index');

    Route::get('api/tasks','ApiTaskController@index');
    Route::post('api/tasks','ApiTaskController@store');

    Route::get('api/tasks/{task}','ApiTaskController@show');

    Route::delete('api/tasks/{task}','ApiTaskController@destroy');
    Route::put('api/tasks/{task}','ApiTaskController@update');
});