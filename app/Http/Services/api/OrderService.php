<?php

namespace App\Http\Services\api;
use App\Http\Requests\api\OrderRequest;
use App\Http\Requests\api\OrderFasterRequest;
use App\Http\Requests\api\CheckCopouneRequest;
use App\Traits\GeneralTrait;
use App\Repository\CopouneRepositoryInterface;
use App\Repository\CartRepositoryInterface;
use App\Repository\OrderTicketRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\TicketRepositoryInterface;
use App\Repository\EventRepositoryInterface;
use App\Repository\OrderTicketInfoRepositoryInterface;
use Auth;
use App\Http\Resources\api\CheckCopouneResource;
use App\Http\Resources\api\FastOrderResource;
use App\Http\Resources\api\OrderResource;
use Illuminate\Support\Facades\DB;

class OrderService
{
    use GeneralTrait;
    protected CopouneRepositoryInterface $copouneRepository;
    protected CartRepositoryInterface $cartRepository;
    protected OrderTicketRepositoryInterface $orderticketRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected TicketRepositoryInterface $ticketRepository;
    protected EventRepositoryInterface $eventRepository;
    protected OrderTicketInfoRepositoryInterface $ordeticketinfoRepository;

    public function __construct(
        CopouneRepositoryInterface $copouneRepository ,
        CartRepositoryInterface $cartRepository ,
        OrderTicketRepositoryInterface $orderticketRepository ,
        OrderRepositoryInterface $orderRepository ,
        TicketRepositoryInterface $ticketRepository ,
        EventRepositoryInterface $eventRepository ,
        OrderTicketInfoRepositoryInterface $ordeticketinfoRepository ,
    )
    {
        $this->copouneRepository = $copouneRepository;
        $this->cartRepository = $cartRepository;
        $this->orderticketRepository = $orderticketRepository;
        $this->orderRepository = $orderRepository;
        $this->ticketRepository = $ticketRepository;
        $this->eventRepository = $eventRepository;
        $this->ordeticketinfoRepository = $ordeticketinfoRepository;
    }

    public function checkCopoune(CheckCopouneRequest $request)
    {
        $copoune = $this->copouneRepository->checkItem('copoune',$request->copoune);
        if($copoune)
        {
            $copoune = $this->copouneRepository->first('copoune',$request->copoune);
            $user = Auth::user();
            $carts = $this->cartRepository->get('user_id',$user->id);
            if(count($carts) == 0)
            {
                $order_tickets = $this->orderticketRepository->get('to_user',$user->id);
                if($copoune->counter  > 0)
                {
                    foreach ($order_tickets as $cart)
                    {
                        foreach ($copoune->events as $copevent)
                        {
                            if($copevent->id == $cart->event_id)
                            {
                                $copoune = new CheckCopouneResource($copoune);
                                return $this->returnData('data',$copoune,__('site.copoune_is_success'));
                            }
                        }
                    }
                    $copoune = new CheckCopouneResource($copoune);
                    return $this->returnError(422,__('site.Copoune_Is_Faild'));
                }
                else
                {
                    return $this->returnError(422,__('site.Copoune_Is_Denied'));
                }
            }
        }
        else
        {
            return $this->returnError(422,__('site.Copoune_Is_Not_Corresct'));
        }
        if($copoune)
        {
            if($copoune->counter  > 0)
            {
                foreach ($carts as $cart)
                {
                    foreach ($copoune->events as $copevent)
                    {
                        if($copevent->id == $cart->event_id)
                        {
                            $copoune = new CheckCopouneResource($copoune);
                            return $this->returnData('data',$copoune,__('site.copoune_is_success'));
                        }
                    }
                }
                $copoune = new CheckCopouneResource($copoune);
//                return $this->returnData('data',$copoune,__('site.Copoune_Is_Faild'));
                return $this->returnError(422,__('site.Copoune_Is_Faild'));
            }
            else
            {
                return $this->returnError(422,__('site.Copoune_Is_Denied'));
            }
        }
        else
        {
            return $this->returnError(422,__('site.Copoune_Is_Not_Corresct'));
        }
    }

    public function createOrder(OrderRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $user = Auth::user();
            if($this->orderRepository->count() > 0)
            {
                $maxordernumber = $this->orderRepository->max('order_number');
                $ordernumber = $maxordernumber + 1;
            }
            else
            {
                $ordernumber = 100;
            }
            $newcopoune = null;
            if($request->copoune != null)
            {
//                $copoune = Copoune::where('copoune',$request->copoune)->where('counter' , '>' , 0)->first();
                $copoune = $this->copouneRepository->getRigthCopoune('copoune',$request->copoune,'counter');
                if($copoune)
                {
                    $newcopoune = $copoune->id;
                }
                if(is_null($copoune))
                {
                    return $this->returnError(422,'Counter Of This Copoune = 0');
                }
            }

            $data = array_merge($request->input(),[
                                                        'copoune_id'=> $newcopoune ,
                                                        'from'=> $user->id ,
                                                        'order_number' => $ordernumber ,
                                                        'totalprice' => $request->totalprice,
                                                        'price_after_copoune' => 0
                                                    ]);
            $order = $this->orderRepository->create($data);
            $order_details = $this->cartRepository->get('user_id',$user->id);
            if(count($order_details) > 0)
            {
                foreach($order_details as $details)
                {
                    $event = $this->eventRepository->getById($details->event_id);
                    $eventCoupons = $event->copounes;
                    if($request->copoune)
                    {
                        if ($eventCoupons->contains('id', $copoune->id))
                        {
                            $newprice = $details->newprice - ($details->counter * $copoune->presentage);
                        }
                        else
                        {
                            $newprice = $details->newprice;
                        }
                        $copoune->update(['counter' => $copoune->counter-1]);
                    }
                    else
                    {
                        $newprice = $details->newprice;
                    }

                    $from_user = $this->ticketRepository->getById($details->ticket_id);

                    if($from_user->user_id)
                    {
                        $from_user_data =  $from_user->user_id;
                    }
                    else
                    {
                        $from_user_data =  $from_user->admin_id;
                    }

                    $data2 = array_merge($request->input(),[
                                                                'event_id'=> $details->event_id ,
                                                                'ticket_id' => $details->ticket_id ,
                                                                'order_id' => $order->id ,
                                                                'quantity' => $details->counter ,
                                                                'newprice' => $newprice,
                                                                'from_user' => $from_user_data,
                                                                'to_user' => $user->id,
                                                                'ticket_info_id' => $details->ticket_info_id,
                                                            ]);

                    $order_ticket = $this->orderticketRepository->create($data2);
                    foreach($details->cart_info as $info)
                    {
                        $data3 = array_merge([
                                                'ticket_info_id'=> $info->ticket_info_id,
                                                'order_ticket_id' => $order_ticket->id,
                                            ]);
                        $order_ticket_info = $this->ordeticketinfoRepository->create($data3);
                    }
                }
            }

            $sumfinalprice = $this->orderticketRepository->sumItems('order_id',$order->id,'newprice');
            $this->orderRepository->update($order->id,['totalprice' => $order_ticket->newprice , 'price_before_copoune' => $sumfinalprice]);
            DB::commit();
            $neworder = new OrderResource($order);
            return $this->returnData('data',$neworder);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError('',$e->getMessage());
        }
    }

    public function createFasterOrder(OrderFasterRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $user = Auth::user();
            if($this->orderRepository->count() > 0)
            {
                $maxordernumber = $this->orderRepository->max('order_number');
                $ordernumber = $maxordernumber + 1;
            }
            else
            {
                $ordernumber = 100;
            }
            $newcopoune = null;
            if($request->copoune != null)
            {
                $copoune = $this->copouneRepository->getRigthCopoune('copoune',$request->copoune,'counter');
                if($copoune)
                {
                    $newcopoune = $copoune->id;
                }
                if(is_null($copoune))
                {
                    return $this->returnError(422,'Counter Of This Copoune = 0');
                }
            }

            $data = array_merge($request->input(),[
                                                        'copoune_id'=> $newcopoune ,
                                                        'from'=> $user->id ,
                                                        'order_number' => $ordernumber ,
                                                        'totalprice' => 0,
                                                        'price_before_copoune' => 0,
                                                    ]);
            $order = $this->orderRepository->create($data);
//            foreach($request->order_details as $details)
//            {
                $event = $this->eventRepository->getById($request->event_id);
                $ticket = $this->ticketRepository->getById($request->ticket_id);
                $eventCoupons = $event->copounes;
                if($request->copoune)
                {
                    if ($eventCoupons->contains('id', $copoune->id))
                    {
                        $newprice = $ticket->totalprice - ($request['counter'] * $copoune->presentage);
//                        $order->update(['price_before_copoune' => $ticket->totalprice]);
                    }
                    else
                    {
                        $newprice = $ticket->totalprice;
//                        $order->update(['price_before_copoune' => $ticket->totalprice]);
                    }
                    $copoune->update(['counter' => $copoune->counter-1]);
                }
                $newprice = $ticket->totalprice;

                $from_user = $this->ticketRepository->getById($request->ticket_id);

                if($from_user)
                {
                    $from_user_data =  $from_user->user_id;
                }
                else
                {
                    $from_user_data =  $from_user->admin_id;
                }

                $data2 = array_merge($request->input(),[
                                                            'event_id'=> $request->event_id,
                                                            'ticket_id' => $request->ticket_id,
                                                            'order_id' => $order->id ,
                                                            'quantity' => $request->counter,
                                                            'newprice' => $newprice * $request->counter,
                                                            'from_user' => $from_user_data,
                                                            'to_user' => $user->id,
                                                        ]);

                $order_ticket = $this->orderticketRepository->create($data2);
                foreach($request->quantityWant as $info)
                {
                    $data3 = array_merge([
                                            'ticket_info_id'=> $info,
                                            'order_ticket_id' => $order_ticket->id,
                                        ]);
                    $order_ticket_info = $this->ordeticketinfoRepository->create($data3);
                }
//            }

            $sumfinalprice = $this->orderticketRepository->sumItems('order_id',$order->id,'newprice');
            $this->orderRepository->update($order->id,['totalprice' => $order_ticket->newprice , 'price_before_copoune' => $sumfinalprice]);
            DB::commit();
            $neworder = new OrderResource($order);
            return $this->returnData('data',__('site.order_created_successfuly'),__('site.order_created_successfuly'));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError('',$e->getMessage());
        }
    }

    public  function  gettotalpricefasterorder()
    {
        $user = Auth::user();
        $order = $this->orderRepository->getlatestOrder('from',$user->id,'created_at');
        $data = new FastOrderResource($order);
        return $this->returnData('data',$data);
    }

}
