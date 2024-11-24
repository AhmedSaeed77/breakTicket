<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\api\CallBackRequest;
use App\Http\Requests\api\CheckoutDetailsRequest;
use App\Http\Requests\api\CheckoutRequest;
use App\Http\Services\api\PaymentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\PaymentRequest;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createPayment(PaymentRequest $request)
    {
        return $this->paymentService->createPayment($request);
    }

    public function electronic_payment(Request $request)
    {
        return $this->paymentService->electronic_payment($request);
    }
    public function electronicCallback(CallBackRequest $request)
    {
        return $this->paymentService->electronicCallback($request);
    }
    public function webhook(Request $request)
    {
        return $this->paymentService->webhook($request);
    }

    public function getCheckoutDetails(CheckoutDetailsRequest $request)
    {
        return $this->paymentService->getCheckoutDetails($request);
    }
    public function getCheckoutId(CheckoutRequest $request)
    {
        return $this->paymentService->getCheckoutId($request);
    }
}
