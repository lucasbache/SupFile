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


Route::get('/test', function(){
    return response()->json(['auth'=>'no']);
});

Route::post('/login', array('uses' => 'Auth\ApiAuthController@login'));


Route::Group(['middleware' => ['auth:api']], function(){
    Route::post('/upload', array('uses' => 'ApiFileController@upload'));
    Route::post('/downloadfile', array('uses' => 'ApiFileController@downloadFileApi'));
    Route::post('/createrepo', array('uses' => 'ApiFileController@repoCreate'));
    Route::post('/listfiles', array('uses' => 'ApiFileController@listFiles'));
    Route::post('/rename/repo', array('uses' => 'ApiFileController@apiRenameRepo'));
    Route::post('/rename/file', array('uses' => 'ApiFileController@apiRenameFile'));
    Route::post('/delete', array('uses' => 'ApiFileController@apiDeleteFile'));
});
