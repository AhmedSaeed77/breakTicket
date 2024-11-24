<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\TicketService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\TicketRequest;
use App\Http\Requests\api\FilterRequest;

class TicketController extends Controller
{
    private TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function store(TicketRequest $request)
    {
        return $this->ticketService->store($request);
    }

    public function getAllQuantityForTicket($id)
    {
        return $this->ticketService->getAllQuantityForTicket($id);
    }

    public function getAllSubcategoryForTicket($id)
    {
        return $this->ticketService->getAllSubcategoryForTicket($id);
    }

    public function filter(FilterRequest $request)
    {
        return $this->ticketService->filter($request);
    }

    public function getAllBoxForTicket($id)
    {
        return $this->ticketService->getAllBoxForTicket($id);
    }
}
