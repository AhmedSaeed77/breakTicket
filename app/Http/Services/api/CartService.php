<?php

namespace App\Http\Services\api;
use App\Traits\GeneralTrait;
use App\Repository\CartRepositoryInterface;
use App\Repository\CartInfoRepositoryInterface;
use App\Repository\TicketRepositoryInterface;
use App\Http\Requests\api\CartRequest;
use App\Http\Resources\api\CartResource;
use App\Http\Resources\api\CartReturnResource;
use App\Http\Resources\api\CartTotalPriceResource;
use Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    use GeneralTrait;
    protected CartRepositoryInterface $catRepository;
    protected CartInfoRepositoryInterface $catinfoRepository;
    protected TicketRepositoryInterface $ticketRepository;

    public function __construct(
        CartRepositoryInterface $catRepository ,
        CartInfoRepositoryInterface $catinfoRepository ,
        TicketRepositoryInterface $ticketRepository
    )
    {
        $this->catRepository = $catRepository;
        $this->catinfoRepository = $catinfoRepository;
        $this->ticketRepository = $ticketRepository;
    }
    public function addToCart(CartRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $user = Auth::user();
            $ticket = $this->ticketRepository->getSpecificTicket('id',$request->ticket_id);
            $newprice = $ticket->totalprice * $request->counter;
            $data = array_merge([
                                    'user_id' => $user->id,
                                    'event_id' => $request->event_id,
                                    'ticket_id' => $request->ticket_id,
                                    'subcategory_id' => $request->subcategory_id,
                                    'counter' => $request->counter,
                                    'newprice' => $newprice
                                ]);
            $carts = $this->catRepository->get('user_id',$user->id);
            $infocounter = 0;
            foreach($carts as $cart)
            {
                if(
                    $cart->user_id == $user->id &&
                    $cart->event_id == $request->event_id &&
                    $cart->ticket_id == $request->ticket_id &&
                    $cart->subcategory_id == $request->subcategory_id
                )
                {
                    foreach($cart->cart_info as $cartinfo)
                    {
                        if($cartinfo->ticket_info_id == $request->quantityWant[$infocounter])
                        {
                            return $this->returnData('data',__('site.this_ticket_already_exist_in_your_cart'),__('site.this_ticket_already_exist_in_your_cart'));
                        }
                        $infocounter++;
                    }
                    $infocounter = 0;
                }
            }
            $cart = $this->catRepository->create($data);
            $cart_data = new CartResource($cart);

//            foreach($ticket->tickests_Info as $ticket_info)
//            {
//                if($request->counter > 0)
//                {
//                    $data2 = array_merge([
//                                            'cart_id' => $cart->id,
//                                            'ticket_info_id' => $ticket_info->id,
//                                        ]);
//                    $cart_info = CartInfo::create($data2);
//                    $request->counter--;
//                }
//
////            $ticket_info->update(['is_salled' => 1]);
//            }
            if($request->quantityWant)
            {
                foreach($request->quantityWant as $ticket_info)
                {
                    $data2 = array_merge([
                                            'cart_id' => $cart->id,
                                            'ticket_info_id' => $ticket_info,
                                        ]);
                    $this->catinfoRepository->create($data2);
//            $ticket_info->update(['is_salled' => 1]);
                }
            }
            else
            {
                return $this->returnData('data',__('site.You_must_specify_the_type_of_ticket'),__('site.You_must_specify_the_type_of_ticket'));
            }
            DB::commit();
            return $this->returnData('data',$cart_data,__('site.The_Item_Added'));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError('',$e->getMessage());
        }
    }
    public function getAllTicketsCart()
    {
        $carts = $this->catRepository->get('user_id',Auth::user()->id,['*'], ['cart_info']);
        foreach($carts as $cart)
        {
            $ticket = $this->ticketRepository->getById($cart->ticket_id);
            $cart->loaction = $ticket->tickests_Info->first();
            $cart->loaction = $cart->loaction->chair_number;
            $cart->row = $ticket->tickests_Info->first();
            $cart->row = $cart->row->row;
            $cart->cart_info = $cart->cart_info;
        }
        $carts_data = CartReturnResource::collection($carts);
        $totalprice = $this->catRepository->sumCartPrice('user_id',Auth::user()->id,'newprice');
        $totalprice_data = new CartTotalPriceResource($totalprice);
        $data = [
                    'cart_data' => $carts_data,
                    'totalprice' => $totalprice_data,
                ];
        return $this->returnData('data',$data);
    }
    public function deleteFromCart($id)
    {
        $this->catRepository->delete($id);
        return $this->returnData('data',__('site.Item_Is_Deleted'),__('site.Item_Is_Deleted'));
    }

}
