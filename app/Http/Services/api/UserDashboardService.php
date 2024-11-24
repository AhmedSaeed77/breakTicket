<?php

namespace App\Http\Services\api;
use App\Http\Mail\ReceiptAccept;
use App\Http\Mail\RecieptTicket;
use App\Http\Mail\UserAccept;
use App\Http\Mail\TicketAccept;
use App\Models\OrderTicketInfo;
use App\Models\Ticket;
use App\Models\TicketInfo;
use App\Models\Event;
use App\Models\Category;
use App\Models\OrderTicket;
use App\Models\Order;
use App\Models\Box;
use App\Models\Setting;
use App\Models\subcategory;
use App\Models\Payment;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\api\UserTicketResource;
use App\Http\Resources\api\UserTicketCollection;
use App\Http\Resources\api\UserOneTicketResource;
use App\Http\Resources\api\UserSalledResource;
use App\Http\Resources\api\UserOneSalledResource;
use App\Http\Resources\api\UserWalletResource;
use App\Http\Resources\api\UserAccountWalletResource;
use App\Http\Resources\api\UserWantSalledResource;
use App\Http\Resources\api\UserNewOrderResource;
use App\Http\Requests\api\CancelTicketRequest;
use App\Http\Requests\api\ChangePriceTicketRequest;
use App\Http\Requests\api\ChangeImageTicketRequest;
use App\Http\Requests\api\AcceptRejectRequest;

class UserDashboardService
{
    use GeneralTrait;

    public function getAllTicketsForUser(Request $request)
    {
        $user = Auth::user();
        $tickets = Ticket::where('user_id', $user->id)
                            ->when($request->filled('category_id'), function ($query) use ($request) {
                                $query->whereHas('event', function ($eventQuery) use ($request) {
                                    $eventQuery->where('cat_id', $request->category_id);
                                });
                            })
                            ->when($request->filled('rank'), function ($query) use ($request) {
                                $query->join('events', 'tickets.event_id', '=', 'events.id')
                                    ->orderBy('events.event_date', $request->rank == 1 ? 'asc' : 'desc')
                                    ->select('tickets.*');
                            }, function ($query) {
                                $query->join('events', 'tickets.event_id', '=', 'events.id')
                                    ->orderBy('events.event_date', 'asc')
                                    ->select('tickets.*');
                            })
                            ->paginate(12);
        foreach($tickets as $ticket)
        {
            $order_ticket = OrderTicket::whereHas('order', function ($query) {
                                            $query->where(['payed' => 1 , 'is_userAccepted' => 2]);
                                        })->where([
                                                    'ticket_id' => $ticket->id,
                                                    'event_id' => $ticket->event->id
                                                ])->sum('quantity');
            $ticket->ticket_salled = $order_ticket;
            $ticket->ticket_not_salled = TicketInfo::where([
                                                                'is_canceled' => 1 ,
                                                                'ticket_id' => $ticket->id
                                                            ])->count();
            // if(in_array($ticket->is_selled, ['Salled', 'مباعه']))
            // {
            //     $ticket->is_accepted = 3;
            // }
        }
        $tickets_data = UserTicketResource::collection($tickets)->response()->getData(true);
        return $this->returnData('data',$tickets_data);
    }

    public function getOneTicketsForUser($id)
    {
        $ticket = Ticket::find($id);
        if(is_null($ticket))
        {
            return $this->returnError('','Ticket Not Found');
        }
        $ticket_data = new UserOneTicketResource($ticket);
        return $this->returnData('data',$ticket_data);
    }

    public function cancelTicket(CancelTicketRequest $request)
    {
        $user = Auth::user();
        if($user->canceltiket == 1)
        {
            $ticket_info = TicketInfo::find($request->ticket_details_id);
            if(is_null($ticket_info))
            {
                return $this->returnError('','Ticket Info Not Found');
            }
            if($ticket_info->is_canceled == 1)
            {
                $ticket_info->update(['is_canceled' => 0]);
                $ticket = Ticket::find($ticket_info->ticket_id);
                $ticket->update(['quantity' => $ticket->quantity + 1]);
                return $this->returnData('data',__('site.Row_Is_Actived'),__('site.Row_Is_Actived'));
            }
            else
            {
                $ticket_info->update(['is_canceled' => 1]);
                $ticket = Ticket::find($ticket_info->ticket_id);
                $ticket->update(['quantity' => $ticket->quantity - 1]);
                return $this->returnData('data',__('site.Row_Is_Canceled'),__('site.Row_Is_Canceled'));
            }
        }
        else
        {
            return $this->returnError(403,__('site.User_Not_have_Permission'),__('site.User_Not_have_Permission'));
        }

    }

    public function changePriceOfTicket(ChangePriceTicketRequest $request)
    {

        $user = Auth::user();
        if($user->changeprice == 1)
        {
            $ticket = Ticket::find($request->ticket_id);
            if(is_null($ticket))
            {
                return $this->returnError('','Ticket Not Found');
            }
            $event = Event::where('id',$ticket->event_id)->first();
            if($event)
            {
                $category = Category::where('id',$event->cat_id)->first();
                if($user->special == 'Special' && $user->commission != 0)
                {
                    $ticket->update(['price' => $request->price , 'totalprice' => $user->commission + $request->price]);
                }
                else
                {
                    $ticket->update(['price' => $request->price , 'totalprice' => $event->commission + $request->price]);
                }
            }
            return $this->returnData('data','Ticket_Price_Is_Updated',__('site.Ticket_Price_Is_Updated'));
        }
        else
        {
            return $this->returnError(403,'User Not have Permission');
        }
    }

    public function changeimage(ChangeImageTicketRequest $request)
    {
        $ticket = TicketInfo::find($request->id);
        $image = $this->handle('image', 'tickets');
        $ticket->update(['image' => $image]);
        return $this->returnData('data',__('site.Image_Is_Updated'),__('site.Image_Is_Updated'));
    }

    public function getAllTicketsSalledForUser()
    {
        $user = Auth::user();
        $orders_tickets = OrderTicket::where('from_user', $user->id)
                                        ->whereHas('order', function ($query) {
                                            $query->where(['is_adminAccepted' =>  1 , 'is_userAccepted' => 2]);
                                        })
                                        ->paginate(12);
        foreach($orders_tickets as $orders_ticket)
        {
            $summoney = 0;
            $ticket = Ticket::find($orders_ticket->ticket_id);
            $summoney += $ticket->price;

            $orders_ticket->ticket = Ticket::find($orders_ticket->ticket_id);
            $orders_ticket->event = Event::find($orders_ticket->event_id);

            $order = Order::where([
                                        'id' => $orders_ticket->order_id,
                                        'is_adminAccepted' => 1,
                                        'is_userAccepted' => 2,
                                    ])->first();
            if($order)
            {
                $orders_ticket->order = $order;
            }
            $subcategory_name = subcategory::find($orders_ticket->ticket->subcategory_id);
            $orders_ticket->subcategory_name = $subcategory_name->name;
            $orders_ticket->summoney = $summoney;
        }
        $tickets_data = UserSalledResource::collection($orders_tickets)->response()->getData(true);
        return $this->returnData('data',$tickets_data);
    }

    public function getOneTicketSalledForUser($id)
    {
        $user = Auth::user();
        $orders_ticket = OrderTicket::find($id);
        $orders_ticket->ticket = Ticket::find($orders_ticket->ticket_id);
        $arr = [];
        foreach($orders_ticket->order_ticket_infos as $info)
        {
            array_push($arr,$info->ticket_info_id);
        }
        $ticket_info = TicketInfo::whereIn('id',$arr)->get();
        $orders_ticket->order;
        $subcategory_name = subcategory::find($orders_ticket->ticket->subcategory_id);
        $orders_ticket->subcategory_name = $subcategory_name->name;
        $orders_ticket->ticket_info = $ticket_info;
        $tickets_data = new UserOneSalledResource($orders_ticket);
        return $this->returnData('data',$tickets_data);
    }

    public function getAllTicketsWantToSalle()
    {
        $user = Auth::user();
        $orders_tickets = OrderTicket::where('to_user', $user->id)
                                        ->whereHas('order', function ($query) {
                                            $query->where(['is_adminAccepted' =>  1 , 'is_userAccepted' => 2]);
                                        })
                                        ->paginate(12);

        foreach($orders_tickets as $orders_ticket)
        {
            $orders_ticket->ticket = Ticket::find($orders_ticket->ticket_id);
            $orders_ticket->event = Event::find($orders_ticket->event_id);

            $order = Order::where([
                                        'id' => $orders_ticket->order_id,
                                        'is_adminAccepted' => 1,
                                        'is_userAccepted' => 2,
                                    ])->first();
            if($order)
            {
                $orders_ticket->order = $order;
                if(app()->getLocale()=='en')
                {
                    if($order->is_adminAccepted == 'Accepted' && $order->is_userAccepted == 'Accepted')
                    {
                        if(app()->getLocale()=='en')
                        {
                            $orders_ticket->status = 'Accepted';
                        }
                        else
                        {
                            $orders_ticket->status = 'مقبوله';
                        }
                    }
                    else
                    {
                        if(app()->getLocale()=='en')
                        {
                            $orders_ticket->status = 'Not Accepted';
                        }
                        else
                        {
                            $orders_ticket->status = 'غير مقبوله';
                        }
                    }
                }
                else
                {
                    if($order->is_adminAccepted == 'مقبول' && $order->is_userAccepted == 'مقبول')
                    {
                        if(app()->getLocale()=='en')
                        {
                            $orders_ticket->status = 'Accepted';
                        }
                        else
                        {
                            $orders_ticket->status = 'مقبوله';
                        }
                    }
                    else
                    {
                        if(app()->getLocale()=='en')
                        {
                            $orders_ticket->status = 'Not Accepted';
                        }
                        else
                        {
                            $orders_ticket->status = 'غير مقبوله';
                        }
                    }
                }

            }

            $subcategory_name = subcategory::find($orders_ticket->ticket->subcategory_id);
            $orders_ticket->subcategory_name = $subcategory_name->name;
        }
        $tickets_data = UserWantSalledResource::collection($orders_tickets)->response()->getData(true);
        return $this->returnData('data',$tickets_data);
    }

    public function getOneTicketsWantToSalle($id)
    {
        $user = Auth::user();
        $orders_ticket = OrderTicket::find($id);
        $orders_ticket->ticket = Ticket::find($orders_ticket->ticket_id);
        $arr = [];
        foreach($orders_ticket->order_ticket_infos as $info)
        {
            array_push($arr,$info->ticket_info_id);
        }
        $ticket = Ticket::find($orders_ticket->ticket_id);
        $orders_ticket->summoney = $ticket->price * $orders_ticket->quantity;
        $ticket_info = TicketInfo::whereIn('id',$arr)->get();
        $orders_ticket->order;
        $event = Event::find($orders_ticket->event_id);
        $subcategory_name = subcategory::find($orders_ticket->ticket->subcategory_id);
        $orders_ticket->event = $event;
        $orders_ticket->subcategory_name = $subcategory_name->name;
        $orders_ticket->ticket_info = $ticket_info;
        $tickets_data = new UserOneSalledResource($orders_ticket);
        return $this->returnData('data',$tickets_data);
    }

    public function getAllNewTickets()
    {
        $user = Auth::user();
        $orders_tickets = OrderTicket::where('from_user', $user->id)
                                        ->whereHas('order', function ($query) {
                                            $query->where(['is_adminAccepted' =>  1 , 'is_userAccepted' => 0]);
                                        })
                                        ->paginate(12);

        foreach($orders_tickets as $orders_ticket)
        {
            $orders_ticket->ticket = Ticket::find($orders_ticket->ticket_id);
            $orders_ticket->event = Event::find($orders_ticket->event_id);

            $order = Order::where([
                                        'id' => $orders_ticket->order_id,
                                        'is_adminAccepted' => 1,
                                        'is_userAccepted' => 0,
                                    ])->first();
            if($order)
            {
                $orders_ticket->order = $order;
            }
            $subcategory_name = subcategory::find($orders_ticket->ticket->subcategory_id);
            $orders_ticket->subcategory_name = $subcategory_name->name;
            $summoney = 0;
            $ticket = Ticket::find($orders_ticket->ticket_id);
            $summoney += $ticket->price * $orders_ticket->quantity;
            $orders_ticket->summoney = $summoney;

            $ticketInfoIds = $orders_ticket->order_ticket_infos->pluck('ticket_info_id')->toArray();
            $orders_ticket->order_ticket_infos = TicketInfo::whereIn('id',$ticketInfoIds)->get();
        }
        $tickets_data = UserNewOrderResource::collection($orders_tickets)->response()->getData(true);
        return $this->returnData('data',$tickets_data);
    }

    public function getOneNewTickets($id)
    {
        $user = Auth::user();
        $orders_ticket = OrderTicket::find($id);
        $orders_ticket->ticket = Ticket::find($orders_ticket->ticket_id);
        $arr = [];
        foreach($orders_ticket->order_ticket_infos as $info)
        {
            array_push($arr,$info->ticket_info_id);
        }
        $ticket_info = TicketInfo::whereIn('id',$arr)->get();
        $orders_ticket->order;
        $subcategory_name = subcategory::find($orders_ticket->ticket->subcategory_id);
        $orders_ticket->subcategory_name = $subcategory_name->name;
        $orders_ticket->ticket_info = $ticket_info;
        $tickets_data = new UserOneSalledResource($orders_ticket);
        return $this->returnData('data',$tickets_data);
    }

    public function acceptReject(AcceptRejectRequest $request)
    {
        $user = Auth::user();
        $setting = Setting::first();
        if($user->acceptreject == 1)
        {
            $order = Order::find($request->order_id);
            if(is_null($order))
            {
                return $this->returnError('','Order Not Found');
            }
            if($request->acceptreject == 1)
            {
                $order->update(['is_userAccepted' => 2]);
                $user = User::find($order->from);
                $details1 = [
                                'message'   => ' تم قبول عمليه شراء التذكره من ناحيه البائع ويمكنك الدخول على حساب البائع للتحقق من اذا كان هناك مبلغ مستحق للبائع حتى تقوم بتحويله اليه',
                                'order_number'      =>  $order->order_number,
                            ];
                Mail::to($setting->mainemail)->send(new RecieptTicket($details1));
                $details2 = [
                                'message'   => 'تم موافقه البائع على طلب الشراء',
                                'event'      =>  $order->order_number,
                            ];
                Mail::to($user->email)->send(new TicketAccept($details2));
                foreach($order->order_tickets as $ticket)
                {
                    $ticketinfos = OrderTicketInfo::where('order_ticket_id',$ticket->id)->get();
                    foreach($ticketinfos as $ticketinfo)
                    {
                        $ticket_info_new = TicketInfo::find($ticketinfo->ticket_info_id);
                        $ticket_info_new->update(['is_salled' => 1]);
                    }
                    $oneticket = Ticket::find($ticket->ticket_id);
                    if($oneticket)
                    {
                        $ticketcounter = TicketInfo::where('ticket_id', $ticket->ticket_id)->where('is_salled', 1)->count();
                        if($oneticket->quantity == $ticketcounter)
                        {
                            // $oneticket->update(['is_selled' => 1 , 'is_accepted' => 3]);
                            $oneticket->update(['is_selled' => 1]);
                        }
                    }
                }
                $orderticketinfo = OrderTicketInfo::whereIn('ticket_info_id',$order->order_tickets->pluck('order_ticket_infos')->flatten()->pluck('ticket_info_id')->toArray())->pluck('order_ticket_id')->toArray();
                $ordertickets = OrderTicket::whereIn('id',$orderticketinfo)->pluck('order_id')->toArray();
                $relatedorders = Order::whereIn('id',$ordertickets)->get();
                foreach($relatedorders as $relatedorder)
                {
                    if($relatedorder->id == $order->id)
                        continue;
                    $relatedorder->update(['is_userAccepted' => 1]);
                }
                return $this->returnData('data',__('site.order_is_accepted'),__('site.order_is_accepted'));
            }
            else
            {
                $order->update(['is_userAccepted' => 1]);
                $user = User::find($order->from);
                $details1 = [
                                'message'   => ' تم رفض عمليه شراء التذكره من ناحيه البائع ويمكنك الدخول على حساب البائع للتحقق من اذا كان هناك مبلغ مستحق للبائع حتى تقوم بتحويله اليه',
                                'order_number'      =>  $order->order_number,
                            ];
                Mail::to($setting->mainemail)->send(new RecieptTicket($details1));
                $details2 = [
                                'message'   => 'تم رفض البائع على التذكره',
                                'event'      =>  $order->order_number,
                            ];
                Mail::to($user->email)->send(new TicketAccept($details2));
                return $this->returnData('data',__('site.order_is_rejectd'),__('site.order_is_rejectd'));
            }
        }
        else
        {
            return $this->returnError(403,'User Not have Permission');
        }
    }

    public function getAllOrderWallet()
    {
        $user = Auth::user();
        $orders_tickets = OrderTicket::where('from_user', $user->id)
                                        // ->where('is_convert',0)
                                        ->whereHas('order', function ($query) {
                                            $query->where(['is_adminAccepted' =>  1 , 'is_userAccepted' => 2]);
                                        })
                                        ->paginate(12);

        foreach($orders_tickets as $orders_ticket)
        {
            $summoney = 0;
            $ticket = Ticket::find($orders_ticket->ticket_id);
            $summoney += $ticket->price;

            $orders_ticket->ticket = Ticket::find($orders_ticket->ticket_id);
            $orders_ticket->event = Event::find($orders_ticket->event_id);

            $order = Order::where([
                                        'id' => $orders_ticket->order_id,
                                        'is_adminAccepted' => 1,
                                        'is_userAccepted' => 2,
                                    ])->first();
            if($order)
            {
                $orders_ticket->order = $order;
            }
            $subcategory_name = subcategory::find($orders_ticket->ticket->subcategory_id);
            $payment_status = Payment::where('order_id',$orders_ticket->order_id)->first();
            $orders_ticket->subcategory_name = $subcategory_name->name;
            $orders_ticket->payment_status = $payment_status->is_accepted;
            $orders_ticket->summoney = $summoney;
        }
        $tickets_data = UserWalletResource::collection($orders_tickets)->response()->getData(true);
        $user->name = $user->name;
        $user->account_number = $user->bank->bank_iban ?? __('site.No_Data');
        $wallets = OrderTicket::where('from_user', $user->id)
                                ->where('is_convert',1)
                                ->whereHas('order', function ($query) {
                                    $query->where(['is_adminAccepted' => 1, 'is_userAccepted' => 2]);
                                })
                                ->with(['order.payments' => function ($query) {
                                    $query->where('is_accepted', 1);
                                }])
                                ->get();
                               //->sum(function ($orderTicket) {
                                 //  return $orderTicket->order->payments->sum('price');
                               //});
        $summoney = 0;
        foreach($wallets as $wallet)
        {
            $ticket = Ticket::find($wallet->ticket_id);
            $summoney += $ticket->price * $wallet->quantity;
        }
        $user->wallet = $summoney;
        $totalprice_data = new UserAccountWalletResource($user);
        $data = [
                    'wallet_data' => $tickets_data,
                    'user_data' => $totalprice_data,
                ];

        return $this->returnData('data',$data);
    }

    public function getOnerderWallet($id)
    {
        $user = Auth::user();
        $orders_ticket = OrderTicket::find($id);
        $orders_ticket->ticket = Ticket::find($orders_ticket->ticket_id);
        $arr = [];
        foreach($orders_ticket->order_ticket_infos as $info)
        {
            array_push($arr,$info->ticket_info_id);
        }
        $ticket = Ticket::find($orders_ticket->ticket_id);
        $orders_ticket->summoney = $ticket->price;
        $ticket_info = TicketInfo::whereIn('id',$arr)->get();
        $orders_ticket->order;
        $event = Event::find($orders_ticket->event_id);
        $subcategory_name = subcategory::find($orders_ticket->ticket->subcategory_id);
        $orders_ticket->subcategory_name = $subcategory_name->name;
        $orders_ticket->ticket_info = $ticket_info;
        $orders_ticket->event = $event;
        $tickets_data = new UserOneSalledResource($orders_ticket);
        return $this->returnData('data',$tickets_data);
    }
}
