<?php

/*
|--------------------------------------------------------------------------
| Service - API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for this service.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Prefix: /api/chatting
Route::group(['prefix' => 'chatting'], function() {
    // Controllers live in src/Services/Chatting/Http/Controllers
    Route::group(['prefix' => 'v1/threads', 'namespace' => 'Api\V1'], function () {
        require __DIR__ . '/api/v1/index.php';
    });
    Route::get('v1/stickers', 'Api\V1\ThreadController@getStickers');
});
