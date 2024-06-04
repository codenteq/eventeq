<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('/event/{event}', [\App\Http\Controllers\EventApplicationController::class, 'show']);
Route::get('/application/{event}', [\App\Http\Controllers\EventApplicationController::class, 'index']);
Route::post('/application/{event}', [\App\Http\Controllers\EventApplicationController::class, 'store'])->name('application.store');
