<?php

namespace App\Http\Controllers;

use App\Filters\EventFilter;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Services\EventService;

class EventController extends Controller
{
    /**
     * List all Events
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(EventFilter $filters)
    {
        $events = Event::filter($filters)
                        ->with('schedules')
                        ->paginate();

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
            'message' => 'Success!',
            'status' => true
        ]);
    }
}
