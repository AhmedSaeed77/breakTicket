<?php

namespace App\Http\Services\Dashboard;
use App\Http\Mail\ReceiptAcceptUser;
use App\Http\Requests\Dashboard\PaymentRequest;
use App\Repository\PaymentRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\AdminRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\EventRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    use GeneralTrait;
    protected PaymentRepositoryInterface $paymentRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected AdminRepositoryInterface $adminRepository;
    protected UserRepositoryInterface $userRepository;
    protected EventRepositoryInterface $eventRepository;

    public function __construct(
        PaymentRepositoryInterface $paymentRepository ,
        OrderRepositoryInterface $orderRepository ,
        AdminRepositoryInterface $adminRepository ,
        UserRepositoryInterface $userRepository ,
        EventRepositoryInterface $eventRepository ,
    )
    {
        $this->paymentRepository = $paymentRepository;
        $this->orderRepository = $orderRepository;
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        $payments = $this->paymentRepository->getAllPayments();
        return view('dashboard.payments.index' , ['payments' => $payments]);
    }

    public function show($id)
    {
        $payment = $this->paymentRepository->getById($id);
        $order = $this->orderRepository->getById($payment->order_id);
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
            $user = $this->userRepository->getById($ticket->to_user);
            $ticket->to_name = $user->name;
        }
        return view('dashboard.payments.show' , ['payment' => $payment , 'order' => $order]);
    }

    public function update(PaymentRequest $request,$id)
    {
        DB::beginTransaction();
        try
        {
            $payment = $this->paymentRepository->getById($id);
            $is_accepted = ($request->is_accepted != null) ? 1 : 0;
            $this->paymentRepository->update($payment->id,['is_accepted' => $is_accepted]);
            $order = $this->orderRepository->getById($payment->order_id);
            $this->orderRepository->update($order->id,['is_adminAccepted' => 1]);
            $user = $this->userRepository->getById($order->from);
            $details = "تم قبول الايصال الخاص بعمليه التحويل من ناحيه المالك";
            Mail::to($user->email)->send(new ReceiptAcceptUser($details));
            DB::commit();
            return redirect('payments')->with(["success"=>__('dashboard.recored updated successfully.')]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->returnError(422,$e->getMessage());
        }
    }

}
