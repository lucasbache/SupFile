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

Route::get('/home', 'repoController@index')->name('home');
Route::get('/', 'repoController@index')->name('home');
Route::post('/home', 'repoController@postRepo');
Route::post('/', 'repoController@postRepo');

Route::get('/profil', 'ProfilController@index')->name('profil');
Route::post('/profil', 'ProfilController@postAuth');

Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

Route::get('upload/{id}/{typeDoss}', 'UploadController@uploadForm');
Route::post('upload/{id}/{typeDoss}', 'UploadController@uploadSubmit');

Route::get('downloadFile/{fileId}', 'DownloadController@downloadFile');
Route::get('downloadRepo/{idDossier}', 'DownloadController@downloadRepo');

Route::get('repertoire/{id}', 'repoController@index');
Route::post('repertoire/{id}', 'repoController@postRepo');

Route::get('rename/{id}/{idRepo}/{objectType}', 'repoController@renameform');
Route::post('rename/{id}/{idRepo}/{objectType}', 'repoController@renameSubmit');

Route::get('suppress/{id}/{objectType}/{dossierId}/{typeDoss}', 'repoController@suppressObject');

Route::get('/howto', 'howtoController@index');
Route::get('/contact', 'contactController@index');
Route::get('/legal', 'legalController@index');
Route::get('/rgpd', 'rgpdController@index');
