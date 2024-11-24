<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\TicketRequest;
use App\Http\Services\Dashboard\TicketService;

class TicketController extends Controller
{
    private TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        return $this->ticketService->index();
    }

    public function show($id)
    {
        return $this->ticketService->show($id);
    }

    public function destroy($id)
    {
        return $this->ticketService->delete($id);
    }

    public function ticketAccept(Request $request)
    {
        return $this->ticketService->ticketAccept($request);
    }

    public function ticketReject(Request $request)
    {
        return $this->ticketService->ticketReject($request);
    }

    public function chanagedirectsale(Request $request)
    {
        return $this->ticketService->chanagedirectsale($request);
    } 

}
