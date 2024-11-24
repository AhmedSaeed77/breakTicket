<?php

namespace App\Http\Services\api;
use App\Repository\EventRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Traits\GeneralTrait;
use App\Http\Resources\api\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\api\EventFilterRequest;

class EventService
{
    use GeneralTrait;
    public function __construct(
        EventRepositoryInterface $eventRepository ,
        CategoryRepositoryInterface $categoryRepository ,
    )
    {
        $this->eventRepository = $eventRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllEvents(Request $request)
    {
        if($request->data == null)
        {
            $events = $this->eventRepository->getAllEventSite();
        }
        else
        {
            $events = $this->eventRepository->getAllEventsSiteSearch($request->data);
        }
        $event_data = EventResource::collection($events);
        return $this->returnData('data',$event_data);
    }
    public function popularevents()
    {
        $events = $this->eventRepository->getAllPopularEvents();
        $event_data = EventResource::collection($events);
        return $this->returnData('data',$event_data);
    }
    public function getAllEventsByCategory($id)
    {
        $category = $this->categoryRepository->getById($id);
        $events = $this->eventRepository->getAllEventsByCategory($id);
        $event_data = EventResource::collection($events);
        $data = [
                    'category_name' => $category->name,
                    'event_data' => $event_data
                ];
        return $this->returnData('data',$data);
    }
    public function getOneEvent($id)
    {
        $event = $this->eventRepository->getOneEventSite($id);
        if($event)
        {
            $event_data = new EventResource($event);
            return $this->returnData('data',$event_data);
        }
        else
        {
            return $this->returnError('','Event Not Found');
        }
    }
    public function search(Request $request)
    {
        $events = $this->eventRepository->getEventSearch($request->data);
        if(count($events) > 0 )
        {
            $event_data = EventResource::collection($events);
            return $this->returnData('data',$event_data);
        }
        else
        {
            return $this->returnError('','Event Not Found');
        }
    }
    public function filter(EventFilterRequest $request)
    {
        $events = $this->eventRepository->getEventFilter($request->input('category_id'),$request->input('data'),$request->input('rank'));
        $event_data = EventResource::collection($events);
        return $this->returnData('data',$event_data);
    }
}
