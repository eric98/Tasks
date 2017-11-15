<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api','prefix' => 'v1', 'middleware' => ['throttle','bindings']], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('tasks',                     'ApiTaskController@index');
        Route::get('tasks/{task}',              'ApiTaskController@show');
        Route::post('tasks',                    'ApiTaskController@store');
        Route::put('tasks/{task}',              'ApiTaskController@update');
        Route::delete('tasks/{task}',           'ApiTaskController@destroy');

        Route::get('v1/users',                     'ApiUserController@index');
        Route::get('v1/users/{task}',              'ApiUserController@show');
        Route::post('v1/users',                    'ApiUserController@store');
        Route::put('v1/users/{task}',              'ApiUserController@update');
        Route::delete('v1/users/{task}',           'ApiUserController@destroy');
    });
});