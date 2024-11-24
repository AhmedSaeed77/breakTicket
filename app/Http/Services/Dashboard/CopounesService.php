<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\CopouneRequest;
use App\Repository\CopouneRepositoryInterface;
use App\Repository\EventRepositoryInterface;
use App\Repository\CopouneEventsRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class CopounesService
{
    use GeneralTrait;
    protected CopouneRepositoryInterface $copouneRepository;
    protected EventRepositoryInterface $eventRepository;
    public function __construct(
        CopouneRepositoryInterface $copouneRepository,
        EventRepositoryInterface $eventRepository,
        CopouneEventsRepositoryInterface $copouneeventRepository
    )
    {
        $this->copouneRepository = $copouneRepository;
        $this->eventRepository = $eventRepository;
        $this->copouneeventRepository = $copouneeventRepository;
    }

    public function index()
    {
        $copounes = $this->copouneRepository->paginate();
        return view('dashboard.copounes.index' , ['copounes' => $copounes]);
    }

    public function create()
    {
        $events = $this->eventRepository->getAll();
        return view('dashboard.copounes.create',['events' => $events]);
    }

    public function store(CopouneRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $type = $request->event_id == 1 ? 1 : 0;
            $data = array_merge($request->input(),['type' => $type]);
            $copoune = $this->copouneRepository->create($data);
            if(is_array($request->event_id))
            {
                foreach($request->event_id as $event)
                {
                    $data2 = array_merge([ 'event_id' => $event , 'copoune_id' => $copoune->id ]);
                    $this->copouneeventRepository->create($data2);
                }
            }
            else
            {
                $events = $this->eventRepository->getAll();
                foreach($events as $event)
                {
                    $data2 = array_merge([ 'event_id' => $event->id , 'copoune_id' => $copoune->id ]);
                    $this->copouneeventRepository->create($data2);
                }
            }
            DB::commit();
            return redirect('copounes')->with(["success"=>__('dashboard.recored created successfully.')]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError('',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $copoune = $this->copouneRepository->getById($id);
        $events = $this->eventRepository->getAll();
        return view('dashboard.copounes.edit' , ['copoune' => $copoune , 'events' => $events]);
    }

    public function update(CopouneRequest $request,$id)
    {
        DB::beginTransaction();
        try
        {
            $copoune = $this->copouneRepository->getById($id);
            $data = array_merge($request->input());
            $this->copouneRepository->update($copoune->id,$data);
            $this->copouneeventRepository->deleteItems('copoune_id',$copoune->id);
            if(is_array($request->event_id))
            {

                foreach($request->event_id as $event)
                {
                    $data2 = array_merge([ 'event_id' => $event , 'copoune_id' => $copoune->id ]);
                    $this->copouneeventRepository->create($data2);
                }
            }
            else
            {
                $events = $this->eventRepository->getAll();
                foreach($events as $event)
                {
                    $data2 = array_merge([ 'event_id' => $event->id , 'copoune_id' => $copoune->id ]);
                    $this->copouneeventRepository->create($data2);
                }
            }
            $eventscount = $this->eventRepository->count();
            if($eventscount == $copoune->events()->count())
            {
                $type = 1;
            }
            else
            {
                $type = 0;
            }
            $this->copouneRepository->update($copoune->id,['type' => $type]);
            DB::commit();
            return redirect('copounes')->with(["success"=>__('dashboard.recored updated successfully.')]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError('',$e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->copouneRepository->delete($id);
        return redirect('copounes')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }
}
