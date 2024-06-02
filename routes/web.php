<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Welcome', [
        'data' => 'Hello World!',
    ]);
});

Route::get('/application', [\App\Http\Controllers\EventApplicationController::class, 'index']);
