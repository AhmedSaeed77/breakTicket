<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Services\Dashboard\PaymentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\PaymentRequest;

class PaymentController extends Controller
{
    private PaymentService $paymentervice;

    public function __construct(PaymentService $paymentervice)
    {
        $this->paymentervice = $paymentervice;
    }

    public function index()
    {
        return $this->paymentervice->index();
    }

    public function show($id)
    {
        return $this->paymentervice->show($id);
    }

    public function update(PaymentRequest $request,$id)
    {
        return $this->paymentervice->update($request,$id);
    }

}
