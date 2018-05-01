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
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::post('/home', array('uses' =>'HomeController@indextest'))->name('home');
Route::post('/', array('uses' =>'HomeController@indextest'))->name('home');
Route::get('/profil', 'ProfilController@index')->name('profil');
Route::post('/profil', array('uses' => 'ProfilController@postAuth'));
//Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
//Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

Route::get('upload/{id}', 'UploadController@uploadForm');
Route::post('upload/{id}', 'UploadController@uploadSubmit');
Route::get('download/{filename}/{dossierActuel}', 'DownloadController@download');
Route::get('createRepo/{id}', 'createRepoController@repoForm');
Route::post('createRepo/{id}', 'createRepoController@repoSubmit');
Route::get('repertoire/{id}', 'repoController@index');
Route::get('rename/{id}', 'repoController@renameFileform');
Route::post('rename/{id}', 'repoController@renameFileSubmit');

