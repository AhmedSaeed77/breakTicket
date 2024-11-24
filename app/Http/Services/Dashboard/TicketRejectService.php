<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\TicketRequest;
use App\Repository\OrderRepositoryInterface;
use App\Repository\AdminRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\TicketRepositoryInterface;
use App\Repository\OrderTicketRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class TicketRejectService
{
    use GeneralTrait;
    protected OrderRepositoryInterface $orderRepository;
    protected AdminRepositoryInterface $adminRepository;
    protected UserRepositoryInterface $userRepository;
    protected TicketRepositoryInterface $ticketRepository;
    protected OrderTicketRepositoryInterface $orderticketRepository;


    public function __construct(
        OrderRepositoryInterface $orderRepository ,
        AdminRepositoryInterface $adminRepository ,
        UserRepositoryInterface $userRepository ,
        TicketRepositoryInterface $ticketRepository ,
        OrderTicketRepositoryInterface $orderticketRepository ,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
        $this->ticketRepository = $ticketRepository;
        $this->orderticketRepository = $orderticketRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->paginate($perPage = 10,$relations = [],'desc',['*'],'is_userAccepted', '1','payed','1');
        foreach($orders as $order)
        {
            $user = $this->userRepository->first('id',$order->from,['name']);
            if($user)
            {
                $order->user_name = $user->name;
            }
            else
            {
                $user = $this->adminRepository->first('id',$order->from,['name']);
                $order->user_name = $user->name;
            }
        }
        return view('dashboard.ticketsrejects.index' , ['orders' => $orders]);
    }

    public function show($id)
    {
        $order = $this->orderRepository->getById($id);
        $user = $this->userRepository->first('id',$order->from,['name']);
        if($user)
        {
            $order->user_name = $user->name;
        }
        else
        {
            $user = $this->adminRepository->first('id',$order->from,['*']);
            $order->user_name = $user->name;
        }

        $tickets = $this->ticketRepository->get('user_id',null,['*']);
        foreach($tickets as $ticket)
        {
            $ticket->checkquantity = $this->orderticketRepository->sumItems('ticket_id',$ticket->id,'quantity');
        }
        return view('dashboard.ticketsrejects.show' , ['order' => $order , 'tickets' => $tickets]);
    }

    public function delete($id)
    {
        $this->orderRepository->delete($id);
        return redirect('userticket')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }

}
