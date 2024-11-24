<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\UserAddTicketRequest;
use App\Repository\TicketRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\OrderTicketRepositoryInterface;
use App\Repository\OrderTicketInfoRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class UserTicketService
{
    use GeneralTrait;
    protected TicketRepositoryInterface $ticketRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected OrderTicketRepositoryInterface $orderticketRepository;
    protected OrderTicketInfoRepositoryInterface $orderticketinfoRepository;
    public function __construct(
        TicketRepositoryInterface $ticketRepository ,
        OrderRepositoryInterface $orderRepository ,
        OrderTicketRepositoryInterface $orderticketRepository ,
        OrderTicketInfoRepositoryInterface $orderticketinfoRepository ,
    )
    {
        $this->ticketRepository = $ticketRepository;
        $this->orderRepository = $orderRepository;
        $this->orderticketRepository = $orderticketRepository;
        $this->orderticketinfoRepository = $orderticketinfoRepository;
    }

    public function edit($order_id,$id)
    {
        $ticket = $this->ticketRepository->getById($id);
        return view('dashboard.userticket.edit',['ticket' => $ticket , 'order_id' => $order_id] );
    }

    public function store(UserAddTicketRequest $request,$order_id)
    {
        DB::beginTransaction();
        try
        {
            if($request->counter)
            {
                $ticket = $this->ticketRepository->getById($request->ticket_id);
                $checkquantity = $this->orderticketRepository->sumItems('ticket_id',$ticket->id,'quantity');
                $check = $ticket->quantity - $checkquantity;
                if($request->counter > $check)
                {
                    return redirect()->back()->withErrors(['error' => __('dashboard.The_Counter_Is_Greater')]);
                }
            }
            $old_order = $this->orderRepository->getById($order_id);
            $ticket = $this->ticketRepository->getById($request->ticket_id);
            if($this->orderRepository->count() > 0)
            {
                $maxordernumber = $this->orderRepository->max('order_number');
                $ordernumber = $maxordernumber + 1;
            }
            else
            {
                $ordernumber = 100;
            }
            $data = array_merge($request->input(),[
                                                        'copoune_id'=> null ,
                                                        'from'=> Auth::user()->id ,
                                                        'order_number' => $ordernumber ,
                                                        'totalprice' => $ticket->totalprice,
                                                        'is_adminAccepted' => 1,
                                                        'is_userAccepted' => 1,
                                                        'payed' => 1,
                                                    ]);
            $order = $this->orderRepository->create($data);

            $data2 = array_merge($request->input(),[
                                                        'event_id'=> $ticket->event_id ,
                                                        'ticket_id' => $ticket->id ,
                                                        'order_id' => $order->id ,
                                                        'newprice' => $ticket->totalprice,
                                                        'from_user' => Auth::user()->id,
                                                        'quantity' => $request->counter ,
                                                        'to_user' => $old_order->from,
                                                    ]);

                $order_ticket = $this->orderticketRepository->create($data2);
                for($i=1;$i<=$request->counter;$i++)
                {
                    if(count($ticket->tickests_Info) == 1)
                    {
                        $info = $ticket->tickests_Info()->take(1)->get()->first();
                    }
                    else
                    {
                        $info = $ticket->tickests_Info()->skip(1)->take(1)->get()->first();
                    }
                    $data3 = array_merge([
                                            'ticket_info_id'=> $info->id,
                                            'order_ticket_id' => $order_ticket->id,
                                        ]);
                    $order_ticket_info = $this->orderticketinfoRepository->create($data3);
                }
            $sumfinalprice = $this->orderticketRepository->sumItems('order_id',$order->id,'newprice');
            $this->orderRepository->update($order->id,['totalprice' => $sumfinalprice , 'price_before_copoune' => $sumfinalprice]);
            if($ticket)
            {
                $checkquantity = $this->orderticketRepository->sumItems('ticket_id',$ticket->id,'quantity');
                if($ticket->quantity == $checkquantity)
                {
                    $this->ticketRepository->update($ticket->id,['is_selled' => 1]);
                }
            }
            DB::commit();
            return redirect()->route('ticketreject.show',$order_id)->with(["success"=>__('dashboard.recored created successfully.')]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
