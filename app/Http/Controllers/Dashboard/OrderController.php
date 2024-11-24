<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Services\Dashboard\OrderService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\OrderRequest;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return $this->orderService->index();
    }

    public function show($id)
    {
        return $this->orderService->show($id);
    }

    public function update(OrderRequest $request,$id)
    {
        return $this->orderService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->orderService->delete($id);
    }
}
