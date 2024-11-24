<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\EventRequest;
use App\Http\Services\Dashboard\EventService;

class EventController extends Controller
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        return $this->eventService->index();
    }

    public function create()
    {
        return $this->eventService->create();
    }

    public function store(EventRequest $request)
    {
        return $this->eventService->store($request);
    }

    public function show($id)
    {
        return $this->eventService->show($id);
    }

    public function edit($id)
    {
        return $this->eventService->edit($id);
    }

    public function update(EventRequest $request,$id)
    {
        return $this->eventService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->eventService->delete($id);
    }

    public function eventstatus($id)
    {
        return $this->eventService->eventstatus($id);
    }

    public function active($id)
    {
        return $this->eventService->active($id);
    }
}
