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

Route::get('/', ['uses' => 'PageController@index', 'as' => 'homepage']);

Route::post('/upload_file', ['uses' => 'PageController@uploadFile', 'as' => 'upload_csv']);
Route::post('/get_models', ['uses' => 'PageController@getModels', 'as' => 'get_models']);
Route::post('/get_submodels', ['uses' => 'PageController@getSubModels', 'as' => 'get_submodels']);