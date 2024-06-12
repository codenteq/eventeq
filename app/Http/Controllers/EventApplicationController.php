<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventApplication\StoreEventApplicationRequest;
use App\Http\Requests\EventApplication\UpdateEventApplicationRequest;
use App\Jobs\AccessCardGenerate;
use App\Models\City;
use App\Models\Event;
use App\Models\EventApplication;
use App\Services\EventApplicationService;
use Illuminate\Http\Client\Request;

class EventApplicationController extends Controller
{
    public function __construct(private readonly EventApplicationService $eventApplicationService)
    {
    }

    public function index(Event $event): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('EventApplicationForm', [
            'cities' => City::all(),
            'event' => $event->load('city')
        ]);
    }

    public function show(Event $event): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('EventDetail', [
            'event' => $event->load('city'),
        ]);
    }

    public function store(StoreEventApplicationRequest $request,int $event): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        $application = $this->eventApplicationService->create($validated, $event);

        return redirect()->route('application.success', $application);
    }

    public function update(UpdateEventApplicationRequest $request, EventApplication $eventApplication): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        $this->eventApplicationService->update($validated, $eventApplication);

        return redirect()->route('application.success', $eventApplication);
    }

    public function success(EventApplication $eventApplication): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('EventApplicationSuccess', [
            'application' => $eventApplication->load(['user','event', 'group.child'])
        ]);
    }

    public function checkIn(EventApplication $eventApplication): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('EventApplicationForm', [
            'cities' => City::all(),
            'event' => Event::find($eventApplication->event_id),
            'application' => $eventApplication->load(['user','event', 'children'])
        ]);
    }

    public function checkInStore(EventApplication $eventApplication): \Illuminate\Http\RedirectResponse
    {
        $eventApplication->update([
            'check_in' => now()
        ]);

        AccessCardGenerate::dispatch($eventApplication->id);

        return redirect()->route('application.success', $eventApplication);
    }
}
