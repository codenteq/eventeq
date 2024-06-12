<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('/events/{event}', [\App\Http\Controllers\EventApplicationController::class, 'show'])->name('event.show');
Route::get('/applications/{event}', [\App\Http\Controllers\EventApplicationController::class, 'index'])->name('application.index');
Route::post('/applications/{event}', [\App\Http\Controllers\EventApplicationController::class, 'store'])->name('application.store');
Route::put('/applications/{event_application}', [\App\Http\Controllers\EventApplicationController::class, 'update'])->name('application.update');
Route::get('/applications/{event_application}/success', [\App\Http\Controllers\EventApplicationController::class, 'success'])->name('application.success');
Route::get('/applications/{event_application}/check-in', [\App\Http\Controllers\EventApplicationController::class, 'checkIn'])->name('application.check-in');
Route::patch('/applications/{event_application}/check-in', [\App\Http\Controllers\EventApplicationController::class, 'checkInStore'])->name('application.check-in.store');
