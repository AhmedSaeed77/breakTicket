<?php

namespace App\Http\Services\api;
use App\Http\Mail\TicketAccept;
use App\Http\Mail\ReceiptAccept;
use App\Http\Requests\api\PaymentRequest;
use App\Http\Requests\api\CallBackRequest;
use App\Http\Requests\api\CheckoutDetailsRequest;
use App\Http\Requests\api\CheckoutRequest;
use App\Models\Copoune;
use App\Models\Event;
use App\Models\TicketInfo;
use App\Traits\GeneralTrait;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Ticket;
use App\Models\OrderTicket;
use App\Models\OrderTicketInfo;
use App\Models\Setting;
use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\api\CheckCopouneResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    use GeneralTrait;

    public function createPayment(PaymentRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $user = Auth::user();
            $setting = Setting::first();
            $data = [
                        'type' => $request->type,
                        'price' => $request->price,
                        'name' => $request->name,
                        'accountnumber' => $request->accountnumber,
                        'order_id' => $request->order_id,
                        'user_id' => $user->id
                    ];
            if($request->hasFile('image'))
            {
                $image = $this->handle('image', 'payments');
                $data = array_merge($data,["image"=>$image]);
            }
            $payment = Payment::create($data);
            Cart::where('user_id',$user->id)->delete();
            $order = Order::find($request->order_id);
            if($order)
            {
                if($request->copoune !== null)
                {
                    foreach($order->order_tickets as $ticket)
                    {
                        $event = Event::find($ticket->event_id);
                        $eventCoupons = $event->copounes;
                        $copoune = Copoune::where('copoune',$request->copoune)->where('counter' , '>' , 0)->first();
                        if ($eventCoupons->contains('id', $copoune->id))
                        {
                            $newprice = $ticket->newprice - ($ticket->counter * $copoune->presentage);
                        }
                        else
                        {
                            $newprice = $ticket->newprice;
                        }
                        $copoune->update(['counter' => $copoune->counter-1]);
                    }
                    $copoune = Copoune::where('copoune',$request->copoune)->where('counter' , '>' , 0)->first();
                    $order->update(['totalprice' => $request->price , 'copoune_id' => $copoune->id]);
                }
//                $order->update(['payed' => 1]);
//                $ticketcontent = null;
//                foreach($order->order_tickets as $ticket1)
//                {
//                    $event_name = Event::find($ticket1->event_id);
//                    $ticketcontent->name = $event_name;
//                }

                $details1 = [
                                'message'   => 'تم رفع ايصال جديد على الموقع فى انتظار الموافقه من قبلكم',
                                'order_number'      =>  $order->order_number,
                            ];
                Mail::to($setting->mainemail)->send(new ReceiptAccept($details1));
                foreach($order->order_tickets as $ticket)
                {
                    $ticketinfos = OrderTicketInfo::where('order_ticket_id',$ticket->id)->get();
                    foreach($ticketinfos as $ticketinfo)
                    {
                        $ticket_info_new = TicketInfo::find($ticketinfo->ticket_info_id);
//                        $ticket_info_new->update(['is_salled' => 1]);
                    }
                    $oneticket = Ticket::find($ticket->ticket_id);
                    if($oneticket)
                    {
                        $ticketorder = OrderTicket::where('order_id',$order->id)->sum('quantity');
//                        if($oneticket->quantity == $ticketorder)
//                        {
//                            $oneticket->update(['is_selled' => 1 , 'is_accepted' => 3]);
//                        }
                    }
                    if($oneticket->user_id != null)
                    {
                        $details2 = [
                                        'message'   => 'يوجد شخص يريد شراء التذكره الخاصه بك',
                                        'event'      =>  $oneticket->event->name,
                                    ];
                        Mail::to($oneticket->user->email)->send(new TicketAccept($details2));
                    }
                }
            }
            DB::commit();
            return $this->returnData('data',$payment,__('site.Payment_bank_success'));
//            return $payment;
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError('',$e->getMessage());
        }
    }

    public function electronic_payment(Request $request)
    {
        $order = Order::find($request->order_id);
        $user = Auth::user();
        if ($order)
        {
            $amount = $order->totalprice ?? 0;
            $currency = 'SAR';
            $first_name = $user->name;
            $last_name = $user->name;
            $email = $user->email;
            $source = $request->payment_token;
//            $redirect_url = route('electronic_payment_callback');
            $webhook_url = route('electronic_payment_webhook');
            $headers = [
                            'Content-Type: application/json',
                            'Authorization: Bearer '.env('TAP_PAYMENT_TEST_SK'),
                            'lang_code: AR',
                        ];
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.tap.company/v2/charges",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $amount,
                    'currency' => $currency,
                    'customer_initiated' => true,
                    'threeDSecure' => true,
                    'save_card' => false,
                    'description' => 'Buy tickets from BreakTicket.',
                    'metadata' => [
                        'udf1' => Carbon::now()->toDateTimeString(),
                        'udf2' => $user->id,
                        'udf3' => $request->order_id,
                        'udf4' => $request->price,
                        'udf5' => $request->copoune,
                    ],
                    'receipt' => [
                        'email' => true,
                        'sms' => false
                    ],
                    'customer' => [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                    ],
                    'source' => [
                        'id' => $source
                    ],
                    'reference' => [
                        ''
                    ],
                    'post' => [
                        'url' => $webhook_url
                    ],
                    'redirect' => [
                        'url' => $request->redirect_url
                    ]
                ]),
                CURLOPT_HTTPHEADER => $headers,
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
//            $payment = json_decode($response)->transaction;
            $payment = json_decode($response);
            if(isset($payment->transaction))
            {
                $payment = $payment->transaction;
            }
            if(!isset($payment->url))
            {
                return $this->returnError('422', __('site.Payment_failed'), __('site.Payment_failed'));
            }
            return $this->returnData('data',$payment->url,__('site.Payment_url'));
        }
        else
        {
            return $this->returnError('422', __('site.no_ticket_in_cart'), __('site.no_ticket_in_cart'));
        }
    }

    public function electronicCallback(CallBackRequest $request)
    {

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.tap.company/v2/charges/".$request->tap_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                                    "Authorization: Bearer ".env('TAP_PAYMENT_TEST_SK'),
                                    "accept: application/json"
                                ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $payment = json_decode($response);
        if ($payment->status == 'CAPTURED')
        {
            $this->activeOrder($payment);
            return $this->returnData('data',__('site.Payment_success'),__('site.Payment_success'));
        }
        else
        {
            return $this->returnError('422', __('site.Payment_failed'), __('site.Payment_failed'));
        }
    }

    public function webhook(Request $request)
    {
        Log::info('webhook started');
        if ($request->status == 'CAPTURED')
        {
            $this->activeOrder($request);
            Log::info('webhook ended');
            return true;
        }
        else
        {
            return false;
        }
    }

    public function activeOrder($source)
    {
        DB::beginTransaction();
        try
        {
            $user = Auth::user();
            $setting = Setting::first();
            $order_id = is_array($source->metadata) ? $source->metadata['udf3'] : $source->metadata->udf3;
            $requestcopoune = is_array($source->metadata) ? $source->metadata['udf4'] : $source->metadata->udf4;
            $finalprice = is_array($source->metadata) ? $source->metadata['udf5'] : $source->metadata->udf5;
            $order = Order::find($order_id);
            $data = [
                        'type' => 1,
                        'order_id' => $order_id,
//                        'price' =>  $order->totalprice,
                        'price' =>  $finalprice,
                        'is_accepted' =>  1,
                        'tap_id' =>  1,
                        'user_id' => $user->id
                    ];
            $payment = Payment::create($data);
            Cart::where('user_id',$user->id)->delete();
            if($order)
            {
                if($requestcopoune !== null)
                {
                    $copoune = Copoune::where('copoune',$requestcopoune)->where('counter' , '>' , 0)->first();
                    $order->update(['totalprice' => $finalprice , 'copoune_id' => $copoune->id]);
                }

                $order->update(['payed' => 1 , 'is_adminAccepted' => 1]);
                $details1 = [
                                'message'   => 'تم رفع ايصال جديد على الموقع فى انتظار الموافقه من قبلكم',
                                'order_number'      =>  $order->order_number,
                            ];
                Mail::to($setting->mainemail)->send(new ReceiptAccept($details1));
                foreach($order->order_tickets as $ticket)
                {
                    $ticketinfos = OrderTicketInfo::where('order_ticket_id', $ticket->id)->get();
                    foreach($ticketinfos as $ticketinfo)
                    {
                        $ticket_info_new = TicketInfo::find($ticketinfo->ticket_info_id);
                        $ticket_info_new->update(['is_salled' => 1]);
                    }
                    $oneticket = Ticket::find($ticket->ticket_id);
                    if($oneticket)
                    {
                        $ticketorder = OrderTicket::where('order_id', $order->id)->sum('quantity');
                        if ($oneticket->quantity == $ticketorder)
                        {
                            $oneticket->update(['is_selled' => 1]);
                        }
                    }
                    if ($oneticket->user_id != null)
                    {
                        $details2 = [
                                        'message'   => 'يوجد شخص يريد شراء التذكره الخاصه بك وتم قبولها من ناحيه المالك',
                                        'event'      =>  $oneticket->event->name,
                                    ];
                        Mail::to($oneticket->user->email)->send(new TicketAccept($details2));
                    }
                }
            }
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError('',$e->getMessage());
        }
    }

    public function getCheckoutId(CheckoutRequest $request)
    {
        // *$request->type 1 for visa or mastercard 2 for mada 3 for apple pay*
        $entityId = '';
        if ($request->type == 1)
        {
            // test
            // $entityId = '8ac7a4c88cae6ecd018cb238c1b209bf';
            // production
            $entityId = '8ac9a4ce8ca66f7f018cd353ed69410b';
        }
        elseif ($request->type == 2)
        {
            // test
            // $entityId = '8ac7a4c88cae6ecd018cb239634c09c3';
            // production
            $entityId = '8ac9a4ce8ca66f7f018cd354abcd4111';
        }
        elseif ($request->type == 3)
        {
            // test
            // $entityId = '8ac7a4c88cd7a11e018ce934f088153b';
            // production
            $entityId = '8acda4cc8d59accb018d5f273f331d9b';
        }
        $order = Order::find($request->order_id);
        $user = Auth::user();
        $price = 0;
        if ($order)
        {
            if ($request->copoune == null)
            {
                $price = $order->totalprice;
            }
            else
            {
                $copoune = Copoune::where('copoune',$request->copoune)->first();
                $order_tickets = OrderTicket::where('to_user',$user->id)->get();
                if($copoune)
                {
                    if($copoune->counter  > 0)
                    {
                        foreach ($order_tickets as $cart)
                        {
                            foreach ($copoune->events as $copevent)
                            {
                                if($copevent->id == $cart->event_id)
                                {
                                    $copoune = new CheckCopouneResource($copoune);
                                    break;
                                }
                            }
                        }
//                        $copoune = new CheckCopouneResource($copoune);
//                        return $this->returnError(422,__('site.Copoune_Is_Faild'));
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

//                $order_details = Cart::where('user_id',$user->id)->get();
                $newprice = 0;
                foreach($order->order_tickets as $details)
                {
                    $event = Event::find($details->event_id);
                    $eventCoupons = $event->copounes;
                    if ($eventCoupons->contains('id', $copoune->id))
                    {
                        $newprice += $details->newprice - ($details->quantity * $copoune->presentage);
                    }
                    else
                    {
                        $newprice += $details->newprice;
                    }
                    $copoune->update(['counter' => $copoune->counter-1]);
                }

                $copoune = Copoune::where('copoune',$request->copoune)->where('counter' , '>' , 0)->first();
                $order->update(['totalprice' => $newprice , 'copoune_id' => $copoune->id]);
                $price = $newprice;
                if($order->copoune_id != null)
                {
                    $order->update(['totalprice' => $newprice,'copoune_id' => $copoune->id]);
                }
            }
            // test
            // $url = "https://eu-test.oppwa.com/v1/checkouts";
            // production
            $url = "https://eu-prod.oppwa.com/v1/checkouts";
            $data = "entityId=" . $entityId .
                "&amount=" . $price .
                "&currency=SAR" .        // *change currency to your currency*
                "&merchantTransactionId=" . $order->id .
                "&customer.email=" . $user->email .
                "&billing.street1=" . 'Riyadh' .
                "&billing.country=SA" .
                "&billing.postcode=620" .
                "&customer.givenName=" . $user->name .
                "&customer.surname=" . $user->name .
                "&billing.city=" . 'Riyadh' .
                "&billing.state=Riyadh" .
                "&paymentType=DB";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            // test
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //     'Authorization:Bearer OGFjN2E0Yzg4Y2FlNmVjZDAxOGNiMjM4MmI4MDA5YmJ8a2JNQzlhMm43ZDhYekZtRw=='
            // ));
            // prduction
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGFjOWE0Y2U4Y2E2NmY3ZjAxOGNkMzUzNGM4YzQxMDZ8YUpxNDNINUMzWGpUQUJNeA=='
            ));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // test
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
            // production
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch))
            {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }
        else
        {
            return $this->returnError('422', __('site.no_ticket_in_cart'), __('site.no_ticket_in_cart'));
        }

    }

    public function getCheckoutDetails(CheckoutDetailsRequest $request)
    {
        $entityId = '';
        if ($request->type == 1)
        {
            // test
            // $entityId = '8ac7a4c88cae6ecd018cb238c1b209bf';
            // production
            $entityId = '8ac9a4ce8ca66f7f018cd353ed69410b';
        }
        elseif ($request->type == 2)
        {
            // test
            // $entityId = '8ac7a4c88cae6ecd018cb239634c09c3';
            // production
            $entityId = '8ac9a4ce8ca66f7f018cd354abcd4111';
        }
        elseif ($request->type == 3)
        {
            // test
            // $entityId = '8ac7a4c88cd7a11e018ce934f088153b';
            // production
            $entityId = '8acda4cc8d59accb018d5f273f331d9b';
        }
        // test
        // $url = "https://eu-test.oppwa.com/v1/checkouts/" . $request->order_transaction_token . "/payment";
        // production 
        $url = "https://eu-prod.oppwa.com/v1/checkouts/" . $request->order_transaction_token . "/payment";
        $url .= "?entityId=" . $entityId;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // test
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Authorization:Bearer OGFjN2E0Yzg4Y2FlNmVjZDAxOGNiMjM4MmI4MDA5YmJ8a2JNQzlhMm43ZDhYekZtRw=='
        // ));
        // production
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjOWE0Y2U4Y2E2NmY3ZjAxOGNkMzUzNGM4YzQxMDZ8YUpxNDNINUMzWGpUQUJNeA=='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        // test
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        // production
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch))
        {
            return curl_error($ch);
        }
        curl_close($ch);
        $res = json_decode($responseData, true);
        Log::info($responseData);
        $order = Order::find($request->order_id);
        if(preg_match("/^(000\.000\.|000\.100\.1|000\.[36])/", $res['result']['code']))
        {
            $this->activeOrder2($request->order_id,$request->order_transaction_token);
            return $this->returnData('data',__('site.Payment_success'),__('site.Payment_success'));
        }
        else
        {
            return $this->returnError('422', __('site.Payment_failed'), __('site.Payment_failed'));
        }
    }

    public function activeOrder2($order_id,$tap_id)
    {
        DB::beginTransaction();
        try
        {
            $user = Auth::user();
            $setting = Setting::first();
            $order = Order::find($order_id);
            $data = [
                        'type' => 1,
                        'order_id' => $order_id,
                        'price' =>  $order->totalprice,
                        'is_accepted' =>  1,
                        'tap_id' =>  $tap_id,
                        'user_id' => $user->id
                    ];
            $payment = Payment::create($data);
            Cart::where('user_id',$user->id)->delete();
            if($order)
            {
                $order->update(['payed' => 1 , 'is_adminAccepted' => 1]);
                $details1 = [
                                'message'   => 'تمت عمليه دفع الكترونى جديده',
                                'order_number'      =>  $order->order_number,
                            ];
                Mail::to($setting->mainemail)->send(new ReceiptAccept($details1));
                foreach($order->order_tickets as $ticket)
                {
                    $ticketinfos = OrderTicketInfo::where('order_ticket_id', $ticket->id)->get();
                    foreach($ticketinfos as $ticketinfo)
                    {
                        $ticket_info_new = TicketInfo::find($ticketinfo->ticket_info_id);
                        $ticket_info_new->update(['is_salled' => 1]);
                    }
                    $oneticket = Ticket::find($ticket->ticket_id);
                    if($oneticket)
                    {
                        $ticketorder = OrderTicket::where('order_id', $order->id)->sum('quantity');
                        if ($oneticket->quantity == $ticketorder)
                        {
                            $oneticket->update(['is_selled' => 1]);
                        }
                    }
                    if ($oneticket->user_id != null)
                    {
                        $details2 = [
                                        'message'   => 'يوجد شخص يريد شراء التذكره الخاصه بك وتم قبولها من ناحيه المالك',
                                        'event'      =>  $oneticket->event->name,
                                    ];
                        Mail::to($oneticket->user->email)->send(new TicketAccept($details2));
                    }
                }
            }
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError('',$e->getMessage());
        }
    }

}
