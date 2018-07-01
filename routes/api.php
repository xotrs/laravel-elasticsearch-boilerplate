<?php

use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'search'], function () {
    Route::get('/', 'SearchController@index');
});

Route::get('board/sync', 'BoardController@syncDatabaseAndElasticsearch');
Route::resource('board', 'BoardController');
//Route::group(['prefix' => 'board'], function () {
//    Route::post('/create-index', 'BoardController@createIndex');
//    Route::get('/{id}', 'BoardController@show');
//    Route::delete('/destroy', 'BoardController@destroy');
//    Route::put('/update', 'BoardController@update');
//});