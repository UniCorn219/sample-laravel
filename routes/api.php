<?php

use Illuminate\Support\Facades\Route;

// This's just test docker compose. You can delete it.
Route::get('/', function () {
    $results = \Illuminate\Support\Facades\DB::select(\Illuminate\Support\Facades\DB::raw('SELECT version()'));
    return response()->json([
        'laravel' => app()->version(),
        'php'     => phpversion(),
        'pgsql'   => $results[0]->version ?? '',
    ]);
});

Route::get('api/health', function () {
    return response()->json(true);
});

Route::post('api/artisan', function () {
    Artisan::call(request()->input('command'));

    return Artisan::output();
});
