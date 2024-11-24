<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\OrderRequest;
use App\Repository\AdminRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\OrderTicketRepositoryInterface;
use App\Repository\TicketRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\EventRepositoryInterface;
use App\Repository\OrderTicketInfoRepositoryInterface;
use App\Repository\TicketInfoRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class OrderService
{
    use GeneralTrait;
    protected OrderRepositoryInterface $orderRepository;
    protected AdminRepositoryInterface $adminRepository;
    protected UserRepositoryInterface $userRepository;
    protected EventRepositoryInterface $eventRepository;
    protected TicketRepositoryInterface $ticketRepository;
    protected OrderTicketRepositoryInterface $orderticketRepository;
    protected OrderTicketInfoRepositoryInterface $orderticketinfoRepository;
    protected TicketInfoRepositoryInterface $ticketinfoRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository ,
        AdminRepositoryInterface $adminRepository ,
        UserRepositoryInterface $userRepository ,
        TicketRepositoryInterface $ticketRepository ,
        OrderTicketRepositoryInterface $orderticketRepository ,
        EventRepositoryInterface $eventRepository ,
        OrderTicketInfoRepositoryInterface $orderticketinfoRepository ,
        TicketInfoRepositoryInterface $ticketinfoRepository,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
        $this->ticketRepository = $ticketRepository;
        $this->orderticketRepository = $orderticketRepository;
        $this->eventRepository = $eventRepository;
        $this->orderticketinfoRepository = $orderticketinfoRepository;
        $this->ticketinfoRepository = $ticketinfoRepository;
    }
    public function index()
    {
        $orders = $this->orderRepository->getAllOrders();
        foreach($orders as $order)
        {
            $user = $this->userRepository->first('id',$order->from,['name']);
            $order->user_name = $user->name;
        }
        return view('dashboard.orders.index' , ['orders' => $orders]);
    }

    public function show($id)
    {
        $order = $this->orderRepository->getById($id);
        foreach($order->order_tickets as $ticket)
        {
            $event = $this->eventRepository->getById($ticket->event_id);
            $ticket->event_name = $event->name;
            $user = $this->userRepository->getById($ticket->from_user);
            if($user)
            {
                $ticket->from_name = $user->name;
            }
            else
            {
                $admin = $this->adminRepository->getFirst();
                $ticket->from_name = $admin->name;
            }
            $user2 = $this->userRepository->getById($ticket->to_user);
            $ticket->to_name = $user2->name;
        }
        return view('dashboard.orders.show' , ['order' => $order]);
    }

    public function update(OrderRequest $request,$id)
    {
        DB::beginTransaction();
        try
        {
            $order = $this->orderRepository->getById($id);
            if(in_array($order->is_userAccepted, ['Not Accepted', 'غير مقبول']))
            {
                return redirect()->back()->withErrors(['error' => __('dashboard.this_order_is_buy_from_user_to_anthor_user')]);
            }
            $is_userAccepted = $request->is_userAccepted ? 2 : 1;
            $is_finished = $request->is_finished ? 1 : 0;
            $this->orderRepository->update($order->id,[
                                                            'is_userAccepted' => $is_userAccepted,
                                                            'is_finished' => $is_finished
                                                        ]);

            foreach($order->order_tickets as $ticket)
            {
//                $ticketinfos = OrderTicketInfo::where('order_ticket_id',$ticket->id)->get();
                $ticketinfos = $this->orderticketinfoRepository->get('order_ticket_id',$ticket->id);
                if(count($ticketinfos) > 0)
                {
                    foreach($ticketinfos as $ticketinfo)
                    {
//                        $ticket_info_new = TicketInfo::find($ticketinfo->ticket_info_id);
                        $ticket_info_new = $this->ticketinfoRepository->getById($ticketinfo->ticket_info_id);
                        $this->ticketinfoRepository->update($ticket_info_new->id,['is_salled' => 1]);
//                        $ticket_info_new->update(['is_salled' => 1]);
                    }
                }
//                $oneticket = Ticket::find($ticket->ticket_id);
                $oneticket = $this->ticketRepository->getById($ticket->ticket_id);
//                $ticketcounter = TicketInfo::where('ticket_id', $ticket->ticket_id)->where('is_salled', 1)->count();
                $ticketcounter = $this->ticketinfoRepository->getCountItems('ticket_id',$ticket->ticket_id,'is_salled','1');
                if($ticketcounter == $oneticket->quantity)
                {
//                    $oneticket->update(['is_selled' => 1]);
                    $this->ticketRepository->update($oneticket->id,['is_selled' => 1]);
                }
            }
//            $orderticketinfo = OrderTicketInfo::whereIn('ticket_info_id',$order->order_tickets->pluck('order_ticket_infos')->flatten()->pluck('ticket_info_id')->toArray())->pluck('order_ticket_id')->toArray();
//            $ordertickets = OrderTicket::whereIn('id',$orderticketinfo)->pluck('order_id')->toArray();
//            $relatedorders = Order::whereIn('id',$ordertickets)->get();

            $arr1 = $order->order_tickets->pluck('order_ticket_infos')->flatten()->pluck('ticket_info_id')->toArray();
            $orderticketinfo = $this->orderticketinfoRepository->filterorder('ticket_info_id',$arr1);
            $ordertickets = $this->orderticketRepository->filterorder1('id',$orderticketinfo);
            $relatedorders = $this->orderRepository->filterorder2('id',$ordertickets);

            foreach($relatedorders as $relatedorder)
            {
                if($relatedorder->id == $order->id)
                    continue;
//                $relatedorder->update(['is_userAccepted' => 1]);
                $this->orderRepository->update($relatedorder->id,['is_userAccepted' => 1]);
            }
            DB::commit();
            return redirect('orders')->with(["success"=>__('dashboard.recored updated successfully.')]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError('',$e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->orderRepository->delete($id);
        return redirect('orders')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }
}
