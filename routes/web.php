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
    //adminlte_routes
    Route::get('tasks_php', 'TaskController@index');
    Route::get('tasks_php/create', 'TaskController@create');
    Route::get('tasks_php/edit/{task}', 'TaskController@edit');
    Route::get('tasks_php/{task}', 'TaskController@show');
    Route::post('tasks_php', 'TaskController@store');
    Route::put('tasks_php/{task}', 'TaskController@update');
    Route::delete('tasks_php/{task}', 'TaskController@destroy');
//    Route::get('tasks', 'TaskController@indexVue');

    //PURE JAVASCRIPT
    Route::view('/tasks', 'tasks');
    Route::view('/tokens', 'tokens');

//
//    Route::get('api/v1/tasks','ApiTaskController@index');
//    Route::post('api/v1/tasks','ApiTaskController@store');
//    Route::get('api/v1/tasks/{task}','ApiTaskController@show');
//    Route::delete('api/v1/tasks/{task}','ApiTaskController@destroy');
//    Route::put('api/v1/tasks/{task}','ApiTaskController@update');
//
//
//
//    Route::get('api/v1/users','ApiUserController@index');
//    Route::post('api/v1/users','ApiUserController@store');
//    Route::get('api/v1/users/{user}','ApiUserController@show');
//    Route::delete('api/v1/users/{user}','ApiUserController@destroy');
//    Route::put('api/v1/users/{user}','ApiUserController@update');
});
