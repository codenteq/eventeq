<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventApplication\StoreEventApplicationRequest;
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

    public function success(EventApplication $eventApplication): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('EventApplicationSuccess', [
            'application' => $eventApplication->load(['user','event', 'group.child'])
        ]);
    }
}
