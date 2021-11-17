<?php

use Illuminate\Support\Facades\Route;

Route::post('/', 'ThreadController@create');
Route::delete('{threadID}', 'ThreadController@destroy');
Route::post('/{threadId}/messages', 'ThreadController@createMessage');
Route::put('/{threadId}/block', 'ThreadController@blockThread');
Route::put('/{threadId}/unblock', 'ThreadController@unblockThread');

//Reservations
Route::post('{threadID}/reservation', 'ThreadController@createReservation');
Route::put('{threadID}/reservation/{reservationId}', 'ThreadController@updateReservation');
Route::delete('{threadID}/reservation/{reservationId}', 'ThreadController@destroyReservation');

//Notification
Route::post('{threadID}/notification', 'ThreadController@settingNotification');

// CHAT WITH STORES
Route::post('/stores', 'ThreadController@createStoreThread');
Route::post('/paycoin', 'ThreadController@createPayCoinMsg');
