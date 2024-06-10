<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('/events/{event}', [\App\Http\Controllers\EventApplicationController::class, 'show'])->name('event.show');
Route::get('/applications/{event}', [\App\Http\Controllers\EventApplicationController::class, 'index'])->name('application.index');
Route::post('/applications/{event}', [\App\Http\Controllers\EventApplicationController::class, 'store'])->name('application.store');
Route::get('/applications/{event_application}/success', [\App\Http\Controllers\EventApplicationController::class, 'success'])->name('application.success');
