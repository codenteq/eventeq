<?php

use App\Jobs\AccessCardGenerate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('/events/{event}', [\App\Http\Controllers\EventApplicationController::class, 'show'])->name('event.show');
Route::get('/applications/{event}', [\App\Http\Controllers\EventApplicationController::class, 'index'])->name('application.index');
Route::post('/applications/{event}', [\App\Http\Controllers\EventApplicationController::class, 'store'])->name('application.store');
Route::put('/applications/{event_application}', [\App\Http\Controllers\EventApplicationController::class, 'update'])->name('application.update');
Route::get('/applications/{event_application}/success', [\App\Http\Controllers\EventApplicationController::class, 'success'])->name('application.success');
Route::get('/applications/{event_application}/check-in', [\App\Http\Controllers\EventApplicationController::class, 'checkIn'])->name('application.check-in');
Route::patch('/applications/{event_application}/check-in', [\App\Http\Controllers\EventApplicationController::class, 'checkInStore'])->name('application.check-in.store');


/*Route::get('/run', function () {
    $applications = \App\Models\EventApplication::query()->where('id', '>', 423)->get();

    //dd($applications);

    $batchSize = 60;
    $initialDelay = 0;
    $delayIncrement = 1;

    foreach ($applications as $index => $application) {
        if ($index % $batchSize === 0 && $index !== 0) {
            $initialDelay += $delayIncrement;
        }

        if ($index < 30) {
            $delay = now();
        } else {
            $delay = now()->addHours($initialDelay);
        }

        AccessCardGenerate::dispatch($application->id)->delay($delay);
    }

    return true;
});

Route::get('/run-checkin', function () {
    $applications = \App\Models\EventApplication::query()->whereNull('check_in')->get();

    //dd($applications);

    $batchSize = 60;
    $initialDelay = 0;
    $delayIncrement = 1;

    foreach ($applications as $index => $application) {
        if ($index % $batchSize === 0 && $index !== 0) {
            $initialDelay += $delayIncrement;
        }

        if ($index < 30) {
            $delay = now();
        } else {
            $delay = now()->addHours($initialDelay);
        }

        $application->user->notify((new App\Notifications\EventCheckInNotification($application->id, $application->event->name))->delay($delay));

        //AccessCardGenerate::dispatch($application->id)->delay($delay);
    }

    return true;
});

Route::get('test', function () {
    ini_set('max_execution_time', '60000');
    $applications = \App\Models\EventApplication::query()
        ->join('users', 'event_applications.user_id', '=', 'users.id')
        ->orderBy('users.name')
        ->select('event_applications.*') // Ensure only event application fields are selected
        ->with(['user', 'children', 'city']) // Load related models
        ->get();

    dd($applications->toArray());

    $pdf = Pdf::loadView('accommodation-certificate', ['applications' => $applications->toArray()])->setPaper([0, 0, 794, 955], 'landscape');

    return $pdf->stream();
});*/
