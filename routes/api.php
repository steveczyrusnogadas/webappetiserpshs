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
Route::get('passers', 'PassersController@index');
Route::get('passer/{id}', 'PassersController@show');
Route::get('passers/search', 'PassersController@search');
Route::get('passers/school', 'PassersController@school');
Route::post('passers', 'PassersController@store');
Route::put('passers/{passer}', 'PassersController@update');
Route::delete('passers/{passer}', 'PassersController@delete');
