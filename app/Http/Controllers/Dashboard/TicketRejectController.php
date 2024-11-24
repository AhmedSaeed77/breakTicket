<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Services\Dashboard\TicketRejectService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketRejectController extends Controller
{
    private TicketRejectService $ticketrejectService;

    public function __construct(TicketRejectService $ticketrejectService)
    {
        $this->ticketrejectService = $ticketrejectService;
    }

    public function index()
    {
        return $this->ticketrejectService->index();
    }

    public function show($id)
    {
        return $this->ticketrejectService->show($id);
    }

    public function destroy($id)
    {
        return $this->ticketrejectService->delete($id);
    }

}
