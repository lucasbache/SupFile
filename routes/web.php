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
Route::get('/home', 'repoController@index')->name('home');
Route::get('/', 'repoController@index')->name('home');
Route::get('home/{id}/{idRepo}/{objectType}', 'repoController@renameform');
Route::post('/{id}/{idRepo}/{objectType}', 'repoController@renameSubmit');

Route::get('/profil', 'ProfilController@index')->name('profil');
Route::post('/profil', array('uses' => 'ProfilController@postAuth'));

//Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
//Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

Route::get('upload/{id}/{typeDoss}', 'UploadController@uploadForm');
Route::post('upload/{id}/{typeDoss}', 'UploadController@uploadSubmit');

Route::get('download/{filename}/{dossierActuel}', 'DownloadController@download');

Route::get('createRepo/{id}', 'createRepoController@repoForm');
Route::post('createRepo/{id}', 'createRepoController@repoSubmit');

Route::get('repertoire/{id}', 'repoController@index');
Route::post('repertoire/{id}', array('uses' => 'repoController@repoSubmit'));
Route::get('rename/{id}/{idRepo}/{objectType}', 'repoController@renameform');
Route::post('rename/{id}/{idRepo}/{objectType}', 'repoController@renameSubmit');

Route::get('rename/{id}/{idRepo}/{objectType}', 'repoController@renameform');
Route::post('rename/{id}/{idRepo}/{objectType}', 'repoController@renameSubmit');

Route::get('suppress/{id}/{objectType}/{dossierId}/{typeDoss}', 'repoController@suppressFile');
