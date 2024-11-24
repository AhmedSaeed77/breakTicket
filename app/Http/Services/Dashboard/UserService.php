<?php

namespace App\Http\Services\Dashboard;
use App\Http\Mail\ConvertMoney;
use App\Http\Requests\Dashboard\UserRequest;
use App\Repository\UserRepositoryInterface;
use App\Repository\TicketRepositoryInterface;
use App\Repository\OrderTicketRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\EventRepositoryInterface;
use App\Repository\subcategoryRepositoryInterface;
use App\Traits\GeneralTrait;
use Mail;

class UserService
{
    use GeneralTrait;

    protected UserRepositoryInterface $userRepository;
    protected TicketRepositoryInterface $ticketRepository;
    protected OrderTicketRepositoryInterface $orderticketRepository;
    protected EventRepositoryInterface $eventRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected subcategoryRepositoryInterface $subcategoryRepository;

    public function __construct(
        UserRepositoryInterface $userRepository ,
        TicketRepositoryInterface $ticketRepository ,
        OrderTicketRepositoryInterface $orderticketRepository ,
        EventRepositoryInterface $eventRepository ,
        OrderRepositoryInterface $orderRepository ,
        subcategoryRepositoryInterface $subcategoryRepository ,
    )
    {
        $this->userRepository = $userRepository;
        $this->ticketRepository = $ticketRepository;
        $this->orderticketRepository = $orderticketRepository;
        $this->eventRepository = $eventRepository;
        $this->orderRepository = $orderRepository;
        $this->subcategoryRepository = $subcategoryRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAllUsers();
        return view('dashboard.user.index' , ['users' => $users]);
    }

    public function create()
    {
        return view('dashboard.user.create');
    }

    public function store(UserRequest $request)
    {
        $data = array_merge($request->input());
        $this->userRepository->create($data);
        return redirect('user')->with(["success"=>__('dashboard.recored created successfully.')]);
    }

    public function show($id)
    {
        $user = $this->userRepository->getById($id);
        $user->wallet = $this->orderticketRepository->getwalletforuser('from_user',$user->id);
        $tickets = $this->ticketRepository->get('user_id',null);
        return view('dashboard.user.show' , ['user' => $user , 'id' => $id , 'tickets' => $tickets]);
    }

    public function edit($id)
    {
        $user = $this->userRepository->getById($id);
        return view('dashboard.user.edit' , ['user' => $user]);
    }

    public function update(UserRequest $request,$id)
    {
        $user = $this->userRepository->getById($id);
        list($is_commission, $specialcommission) = ($request->is_commission != null) ? [1, $request->commission] : [0, 0];
        $special = ($request->special != null) ? 1 : 0;
        $this->userRepository->update($user->id,[
                                                    'special' => $special,
                                                    'is_commission' => $is_commission,
                                                    'commission' => $specialcommission,
                                                ]);
        return redirect('user')->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);
        return redirect('user')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }

    public function getUserSales($id)
    {
        $user = $this->userRepository->getById($id);
        $orders_tickets = $this->orderticketRepository->getordersticketsusersales('from_user',$user->id);
        foreach($orders_tickets as $orders_ticket)
        {
            $orders_ticket->ticket = $this->ticketRepository->getById($orders_ticket->ticket_id);
            $orders_ticket->event = $this->eventRepository->getById($orders_ticket->event_id);
            $order = $this->orderRepository->getItem(['id','is_adminAccepted','is_userAccepted'],[$orders_ticket->order_id,'1','2']);
            if($order)
            {
                $orders_ticket->order = $order;
            }
            $subcategory_name = $this->subcategoryRepository->getById($orders_ticket->ticket->subcategory_id);
            $orders_ticket->subcategory_name = $subcategory_name->name;
        }
        $totalprice = 0;
        foreach($orders_tickets as $user)
        {
            $ticket = $this->ticketRepository->getById($user->ticket_id);
            if($ticket)
            {
                $totalprice += $user->quantity * $ticket->price;
            }
        }
        return view('dashboard.user.showSales' , ['orders_tickets' => $orders_tickets , 'totalprice' => $totalprice]);
    }

    public function getUserPurchases($id)
    {
        $user = $this->userRepository->getById($id);
        $orders_tickets = $this->orderticketRepository->getordersticketsusersales('to_user', $user->id);
        foreach($orders_tickets as $orders_ticket)
        {
            $orders_ticket->ticket = $this->ticketRepository->getById($orders_ticket->ticket_id);
            $orders_ticket->event = $this->eventRepository->getById($orders_ticket->event_id);
            $order = $this->orderRepository->getItem(['id','is_adminAccepted','is_userAccepted'],[$orders_ticket->order_id,'1','2']);
            if($order)
            {
                $orders_ticket->order = $order;
            }
            $subcategory_name = $this->subcategoryRepository->getById($orders_ticket->ticket->subcategory_id);
            $orders_ticket->subcategory_name = $subcategory_name->name;
        }

        $totalprice = 0;
        foreach($orders_tickets as $user)
        {
            $totalprice += $user->newprice;
        }
        return view('dashboard.user.showPurchases' , ['orders_tickets' => $orders_tickets , 'totalprice' => $totalprice]);
    }

    public function ticketconvert($id)
    {
        $orders_ticket = $this->orderticketRepository->getById($id);
        $this->orderticketRepository->update($orders_ticket->id,['is_convert' => 1]);
        $user = $this->userRepository->getById($orders_ticket->from_user);
        $ticket = $this->ticketRepository->getById($orders_ticket->ticket_id);
        $details = [
                        'message'           =>  'تم تحويل سعر التذكره من الماللك',
                        'order_number'      =>  $orders_ticket->order->order_number,
                        'amount'            =>  $ticket->price * $orders_ticket->quantity
                    ];

        Mail::to($user->email)->send(new ConvertMoney($details));
        return redirect()->back()->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

}
