<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\AdminTicketRequest;
use App\Repository\TicketRepositoryInterface;
use App\Repository\EventRepositoryInterface;
use App\Repository\subcategoryRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Auth;

class AdminTicketService
{
    use GeneralTrait;
    protected TicketRepositoryInterface $ticketRepository;
    protected EventRepositoryInterface $eventRepository;
    protected subcategoryRepositoryInterface $subcategoryRepository;

    public function __construct(
        TicketRepositoryInterface $ticketRepository ,
        EventRepositoryInterface $eventRepository ,
        subcategoryRepositoryInterface $subcategoryRepository ,
    )
    {
        $this->ticketRepository = $ticketRepository;
        $this->eventRepository = $eventRepository;
        $this->subcategoryRepository = $subcategoryRepository;
    }

    public function index()
    {
        $tickets = $this->ticketRepository->paginate($perPage = 10,$relations = [],'desc',['*'],'user_id', null);
        return view('dashboard.admintickets.index' , ['tickets' => $tickets]);
    }

    public function create()
    {
        $events = $this->eventRepository->getAllEventSite();
        return view('dashboard.admintickets.create',compact('events'));
    }

    public function store(AdminTicketRequest $request)
    {
        $is_adjacent = $request->is_adjacent != null ? 1 : 0;
        $is_direct_sale = $request->is_direct_sale != null ? 1 : 0;
        $data = array_merge($request->input(),[
                                                    'is_direct_sale' => $is_direct_sale ,
                                                    'is_adjacent' => $is_adjacent ,
                                                    'admin_id' => Auth::user()->id ,
                                                    'is_accepted' => 2
                                                ]);
        $ticket = $this->ticketRepository->create($data);
        $event = $this->eventRepository->first('id',$ticket->event_id);
        if($event)
        {
            $this->ticketRepository->update($ticket->id,['totalprice' => $event->commission + $ticket->price]);
        }
        return redirect('adminticket')->with(["success"=>__('dashboard.recored created successfully.')]);
    }

    public function edit($id)
    {
        $ticket = $this->ticketRepository->getById($id);
        $events = $this->eventRepository->getAll();
        return view('dashboard.admintickets.edit' , ['ticket' => $ticket , 'events' => $events]);
    }

    public function update(AdminTicketRequest $request,$id)
    {
        $ticket = $this->ticketRepository->getById($id);
        $is_adjacent = $request->is_adjacent != null ? 1 : 0;
        $is_direct_sale = $request->is_direct_sale != null ? 1 : 0;
        $data = array_merge($request->input(),['is_direct_sale' => $is_direct_sale , 'is_adjacent' => $is_adjacent , 'admin_id' => Auth::user()->id]);
        $this->ticketRepository->update($ticket->id,$data);
        return redirect('adminticket')->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function show($id)
    {
        $ticket = $this->ticketRepository->getById($id);
        return view('dashboard.admintickets.show' , ['ticket' => $ticket]);
    }

    public function delete($id)
    {
        $this->ticketRepository->delete($id);
        return redirect('adminticket')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }

    public function getAllBoxes($id)
    {

    }

    public function getAllsubcategories($id)
    {
        $subcategories = $this->subcategoryRepository->getAllsubcategories($id);
        return $subcategories;
    }

}
