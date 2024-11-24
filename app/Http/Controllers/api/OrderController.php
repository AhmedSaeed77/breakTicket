<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\OrderService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\OrderRequest;
use App\Http\Requests\api\OrderFasterRequest;
use App\Http\Requests\api\CheckCopouneRequest;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function checkCopoune(CheckCopouneRequest $request)
    {
        return $this->orderService->checkCopoune($request);
    }

    public function createOrder(OrderRequest $request)
    {
        return $this->orderService->createOrder($request);
    }

    public function createFasterOrder(OrderFasterRequest $request)
    {
        return $this->orderService->createFasterOrder($request);
    }

    public function gettotalpricefasterorder()
    {
        return $this->orderService->gettotalpricefasterorder();
    }
}
