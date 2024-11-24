<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\EventService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\EventFilterRequest;

class EventController extends Controller
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function getAllEvents(Request $request)
    {
        return $this->eventService->getAllEvents($request);
    }

    public function getOneEvent($id)
    {
        return $this->eventService->getOneEvent($id);
    }

    public function search(Request $request)
    {
        return $this->eventService->search($request);
    }

    public function popularevents()
    {
        return $this->eventService->popularevents();
    }

    public function getAllEventsByCategory($id)
    {
        return $this->eventService->getAllEventsByCategory($id);
    }

    public function filter(EventFilterRequest $request)
    {
        return $this->eventService->filter($request);
    }

}
