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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/proxy/oauth/token', 'PasswordGrantProxyController@issueToken');
});

Route::group(['middleware' => 'api', 'prefix' => 'v1', 'middleware' => ['throttle', 'bindings']], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('tasks', 'ApiTaskController@index');
        Route::get('tasks/{task}', 'ApiTaskController@show');
        Route::post('tasks', 'ApiTaskController@store');
        Route::put('tasks/{task}', 'ApiTaskController@update');
        Route::delete('tasks/{task}', 'ApiTaskController@destroy');

        Route::post('complete-task/{task}', 'ApiCompleteTaskController@store');
        Route::delete('complete-task/{task}', 'ApiCompleteTaskController@destroy');

        Route::put('description-task/{task}', 'ApiDescriptionTaskController@update');

        Route::put('user_id-task/{task}', 'ApiUserIdTaskController@update');

        Route::get('users', 'ApiUserController@index');
        Route::get('users/{user}', 'ApiUserController@show');
        Route::post('users', 'ApiUserController@store');
        Route::put('users/{user}', 'ApiUserController@update');
        Route::delete('users/{user}', 'ApiUserController@destroy');
    });
});
