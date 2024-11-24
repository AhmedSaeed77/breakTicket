<?php

namespace App\Http\Services\Dashboard;
use App\Http\Mail\TicketAccept;
use App\Http\Requests\Dashboard\TicketRequest;
use App\Repository\TicketRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Mail;

class TicketService
{
    use GeneralTrait;
    protected TicketRepositoryInterface $ticketRepository;
    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function index()
    {
        $tickets = $this->ticketRepository->paginate($perPage = 10,$relations = [],'desc',['*'],'admin_id', null);
        return view('dashboard.tickets.index' , ['tickets' => $tickets]);
    }

    public function show($id)
    {
        $ticket = $this->ticketRepository->getById($id);
        return view('dashboard.tickets.show' , ['ticket' => $ticket]);
    }

    public function delete($id)
    {
        $this->ticketRepository->delete($id);
        return redirect('userticket')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }

    public function ticketAccept(Request $request)
    {
        $ticket = $this->ticketRepository->getById($request->ticket_id);
        $this->ticketRepository->update($ticket->id,['is_accepted' => 2]);
        $details = [
                        'message'   => 'تم تفعيل التذكره بنجاح',
                        'event'      =>  $ticket->event->name,
                    ];
        Mail::to($ticket->user->email)->send(new TicketAccept($details));
        return redirect()->back()->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function ticketReject(Request $request)
    {
        $ticket = $this->ticketRepository->getById($request->ticket_id);
        $this->ticketRepository->update($ticket->id,['is_accepted' => 1]);
        return redirect()->back()->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function chanagedirectsale(Request $request)
    {
        $ticket = $this->ticketRepository->getById($request->ticket_id);
        $this->ticketRepository->update($ticket->id,['is_direct_sale' => $request->is_direct_sale ? 1 : 0]);
        return redirect()->back()->with(["success"=>__('dashboard.recored updated successfully.')]);
    }
}
