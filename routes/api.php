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
Route::get('passers', 'ExamineesController@index');
Route::get('passer/{id}', 'ExamineesController@show');
Route::get('passers/search', 'ExamineesController@search');
Route::get('passers/school', 'ExamineesController@school');
Route::post('passers', 'ExamineesController@store');
Route::put('passers/{passer}', 'ExamineesController@update');
Route::delete('passers/{passer}', 'ExamineesController@delete');
