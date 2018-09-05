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

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', 'ClientsController@index');
        Route::get('/{clients}', 'ClientsController@show');
        Route::post('/store', 'ClientsController@store');
        Route::put('/update/{clients}', 'ClientsController@update');
        Route::delete('/delete/{clients}', 'ClientsController@delete');
    });
    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', 'ProjectsController@index');
        Route::get('/{projects}', 'ProjectsController@show');
        Route::post('/store', 'ProjectsController@store');
        Route::put('/update/{projects}', 'ProjectsController@update');
        Route::delete('/delete/{projects}', 'ProjectsController@delete');
    });
});
