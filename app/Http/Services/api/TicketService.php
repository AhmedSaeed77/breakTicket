<?php

namespace App\Http\Services\api;
use App\Http\Mail\TicketAcceptFromAdmin;
use App\Repository\TicketRepositoryInterface;
use App\Repository\EventRepositoryInterface;
use App\Repository\TicketInfoRepositoryInterface;
use App\Repository\SettingRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Resources\api\TicketResource;
use App\Http\Resources\api\FilterResource;
use App\Http\Resources\api\FilterSubCategoryResource;
use App\Http\Resources\api\FilterBoxResource;
use App\Http\Requests\api\TicketRequest;
use Auth;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\api\FilterRequest;

class TicketService
{
    use GeneralTrait;
    protected TicketRepositoryInterface $ticketRepository;
    protected EventRepositoryInterface $eventRepository;
    protected TicketInfoRepositoryInterface $ticketinfoRepository;
    protected SettingRepositoryInterface $settingRepository;


    public function __construct(
        TicketRepositoryInterface $ticketRepository ,
        EventRepositoryInterface $eventRepository ,
        TicketInfoRepositoryInterface $ticketinfoRepository ,
        SettingRepositoryInterface $settingRepository ,
    )
    {
        $this->ticketRepository = $ticketRepository;
        $this->eventRepository = $eventRepository;
        $this->ticketinfoRepository = $ticketinfoRepository;
        $this->settingRepository = $settingRepository;
    }

    public function store(TicketRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $user = Auth::user();
            $is_accepted = in_array($user->special, ['مميز', 'Special']) ? 2 : 0;
            $data = array_merge([
                                    'event_id' => $request->event_id,
                                    'subcategory_id' => $request->subcategory_id,
                                    'price' => $request->price,
                                    'quantity' => $request->quantity,
                                    'is_adjacent' => $request->is_adjacent,
                                    'is_direct_sale' => $request->is_direct_sale,
                                    'user_id' => $user->id,
                                    'is_accepted' => $is_accepted
                                ]);
            $ticket = $this->ticketRepository->create($data);
            $event = $this->eventRepository->first('id',$ticket->event_id);
            if($event)
            {
                $this->ticketRepository->update($ticket->id,['totalprice' => ($user->is_commission == 1 && $user->commission != 0) ? $user->commission + $ticket->price : $event->commission + $ticket->price]);
            }
            $ticket_data = new TicketResource($ticket);
            $i=0;
            foreach($request->info as $detail)
            {
                $image = $this->handle('info.'.$i.'.image', 'ticketinfo');
                $data_info = array_merge([
                                            'image' => $image??null,
                                            'row' => $detail['row']??null,
                                            'chair_number' => $detail['chair_number']??null,
                                            'ticket_id' => $ticket->id
                                        ]);
                $this->ticketinfoRepository->create($data_info);
                $i++;
            }
            DB::commit();
            $setting = $this->settingRepository->getFirst();
            $details = 'تم اضافه تذكره على الموقع فى انتظار الموافقه عليها';
            Mail::to($setting->mainemail)->send(new TicketAcceptFromAdmin($details));
            return $this->returnData('data',$ticket_data,__('site.ticket_is_added'));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError(422,$e->getMessage());
        }
    }

    // public function store(TicketRequest $request)
    // {
    //     DB::beginTransaction();
    //     try
    //     {
    //         if($request->flag == 0)
    //         {
    //             $user = Auth::user();
    //             if($user->special == 'Special')
    //             {
    //                 $is_accepted = 2;
    //             }
    //             else
    //             {
    //                 $is_accepted = 0;
    //             }
    //             $data = array_merge([
    //                                     'event_id' => $request->event_id,
    //                                     'box_id' => $request->box_id,
    //                                     'subcategory_id' => $request->subcategory_id,
    //                                     'price' => $request->price,
    //                                     'quantity' => $request->quantity,
    //                                     'is_adjacent' => $request->is_adjacent,
    //                                     'is_direct_sale' => $request->is_direct_sale,
    //                                     'user_id' => $user->id,
    //                                     'is_accepted' => $is_accepted
    //                                 ]);
    //             $ticket = Ticket::create($data);
    //             $event = Event::where('id',$ticket->event_id)->first();
    //             if($event)
    //             {
    //                 $category = Category::where('id',$event->cat_id)->first();
    //                 if($user->special == 'Special' && $user->commission != 0)
    //                 {
    //                     $ticket->update(['totalprice' => $user->commission + $ticket->price]);
    //                 }
    //                 else
    //                 {
    //                     $ticket->update(['totalprice' => $category->commission + $ticket->price]);
    //                 }
    //             }
    //             $ticket_data = new TicketResource($ticket);
    //             $i=0;
    //             foreach($request->info as $detail)
    //             {
    //                     $image = $this->handle('info.'.$i.'.image', 'tickets');
    //                     $data_info = array_merge([
    //                                                 'image' => $image??null,
    //                                                 'row' => $detail['row']??null,
    //                                                 'chair_number' => $detail['chair_number']??null,
    //                                                 'ticket_id' => $ticket->id
    //                                             ]);
    //                     TicketInfo::create($data_info);
    //                 $i++;
    //             }
    //         }
    //         else
    //         {
    //             $user = Auth::user();
    //             if($user->special == 'Special')
    //             {
    //                 $is_accepted = 2;
    //             }
    //             else
    //             {
    //                 $is_accepted = 0;
    //             }
    //             $data = array_merge([
    //                                     'event_name' => $request->event_name,
    //                                     'box_name' => $request->box_name,
    //                                     'subcategory_name' => $request->subcategory_name,
    //                                     'price' => $request->price,
    //                                     'quantity' => $request->quantity,
    //                                     'is_adjacent' => $request->is_adjacent,
    //                                     'is_direct_sale' => $request->is_direct_sale,
    //                                     'user_id' => $user->id,
    //                                     'is_accepted' => $is_accepted
    //                                 ]);
    //             $ticket = Ticket::create($data);
    //             $event = Event::where('id',$ticket->event_id)->first();
    //             if($event)
    //             {
    //                 $category = Category::where('id',$event->cat_id)->first();
    //                 if($user->special == 'Special' && $user->commission != 0)
    //                 {
    //                     $ticket->update(['totalprice' => $user->commission + $ticket->price]);
    //                 }
    //                 else
    //                 {
    //                     $ticket->update(['totalprice' => $category->commission + $ticket->price]);
    //                 }
    //             }
    //             $ticket_data = new TicketResource($ticket);
    //             $i=0;
    //             foreach($request->info as $detail)
    //             {
    //                     $image = $this->handle('info.'.$i.'.image', 'tickets');
    //                     $data_info = array_merge([
    //                                                 'image' => $image??null,
    //                                                 'row' => $detail['row']??null,
    //                                                 'chair_number' => $detail['chair_number']??null,
    //                                                 'ticket_id' => $ticket->id
    //                                             ]);
    //                     TicketInfo::create($data_info);
    //                 $i++;
    //             }
    //         }

    //         DB::commit();
    //         return $this->returnData('data',$ticket_data,__('site.ticket_is_added'));
    //     }
    //     catch (\Exception $e)
    //     {
    //         DB::rollback();
    //         return $this->returnError(422,$e->getMessage());
    //     }
    // }

    public function getAllQuantityForTicket($id)
    {
        $quantities = $this->ticketRepository->getAllQuantityForTicket('event_id',$id,'quantity');
        return $this->returnData('data',$quantities);
    }

    public function getAllSubcategoryForTicket($id)
    {
        $event = $this->eventRepository->getOneEvent('id',$id,'slug_ar',$id,'slug_en',$id);
        return $this->returnData('data', (count($event->subcategories) > 0) ? FilterSubCategoryResource::collection($event->subcategories) : []);
    }

    public function getAllBoxForTicket($id)
    {
        $event = $this->eventRepository->getOneEvent('id',$id,'slug_ar',$id,'slug_en',$id);
        return $this->returnData('data', (count($event->boxes) > 0) ? FilterBoxResource::collection($event->boxes) : []);
    }

    public function filter(FilterRequest $request)
    {
//        $event = Event::where('id',$request->event_id)->orWhere('slug_ar',$request->event_id)->orWhere('slug_en',$request->event_id)->first();
//        $tickets = Ticket::with(['tickests_Info' => function ($query) {
//                                    $query->where('is_canceled', 0);
//                                    $query->where('is_salled', 0);
//                                }])
//            ->where('is_accepted',2)
//            // ->where('is_selled',0)
//            ->where('quantity','!=',0)
//            ->when($event != null, function ($query) use ($event) {
//                return $query->where('event_id', $event->id);
//            })
//            ->when($request->subcategory_id != null, function ($query) use ($request) {
//                return $query->where('subcategory_id', $request->subcategory_id);
//            })
//            ->when($request->quantity != null, function ($query) use ($request) {
//                return $query->where('quantity', $request->quantity);
//            })
//            ->when($request->is_adjacent != null, function ($query) use ($request) {
//                return $query->where('is_adjacent', $request->is_adjacent);
//            })
//            ->has('tickests_Info', '>=', 1)
//            ->orderBy('is_selled', 'asc')
//            ->orderBy('totalprice', 'asc')->get();

            $event = $this->eventRepository->getOneEvent('id',$request->event_id,'slug_ar',$request->event_id,'slug_en',$request->event_id);
            $tickets = $this->ticketRepository->filterticket($event,$request->event_id,$request->subcategory_id,$request->quantity,$request->is_adjacent);
            foreach($tickets as $ticket)
            {
                $ticket->location = $ticket->subcategory;
                $ticket->counter = $ticket->tickests_Info->where('is_salled', 0)->count();
                $ticket->salled = in_array($ticket->is_selled, ['Salled', 'مباعه']) ? 1 : 0;
            }
            $tickets_data = FilterResource::collection($tickets);
            return $this->returnData('data',$tickets_data);
    }
}
