<?php

namespace App\Http\Controllers;

use App\Filters\EventScheduleFilter;
use App\Http\Requests\EventStoreRequest;
use App\Models\EventSchedule;
use App\Services\EventService;

class EventController extends Controller
{
    /**
     * List all Events
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(EventScheduleFilter $filters)
    {
        $events = EventSchedule::filter($filters)
                    ->with('event')
                    ->get();

        return response()->json($events);
    }

    /**
     * Store Events.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EventStoreRequest $request, EventService $event)
    {
        $event->store($request->validated());

        return response()->json([
            'message' => 'Event successfully saved!',
            'status' => true
        ]);
    }
}
