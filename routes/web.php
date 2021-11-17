<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

    Route::get('/documentation/yaml-file/{file}', 'ApiDocumentController@getYamlFile');
    Route::get('/documentation/yaml-file/path/{folder}/{file}', 'ApiDocumentController@getYamlPathFile');
    Route::get('/documentation/yaml-file/response/{file}', 'ApiDocumentController@getYamlResponseFile');
    Route::get('/documentation/yaml-file/models/{file}', 'ApiDocumentController@getYamlModelsFile');
    Route::get('/documentation/api', 'ApiDocumentController@getApiDocs');
