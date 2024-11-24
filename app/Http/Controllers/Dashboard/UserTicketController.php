<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Services\Dashboard\UserTicketService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use App\Http\Requests\Dashboard\UserAddTicketRequest;

class UserTicketController extends Controller
{
    private UserTicketService $userticketService;

    public function __construct(UserTicketService $userticketService)
    {
        $this->userticketService = $userticketService;
    }

    public function edit($order_id,$id)
    {
        return $this->userticketService->edit($order_id,$id);
    }

    public function store(UserAddTicketRequest $request,$order_id)
    {
        return $this->userticketService->store($request,$order_id);
    }
}
