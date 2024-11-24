<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\UserDashboardService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\CancelTicketRequest;
use App\Http\Requests\api\ChangePriceTicketRequest;
use App\Http\Requests\api\ChangeImageTicketRequest;
use App\Http\Requests\api\AcceptRejectRequest;

class UserDashboardController extends Controller
{
    private UserDashboardService $userdashboardService;

    public function __construct(UserDashboardService $userdashboardService)
    {
        $this->userdashboardService = $userdashboardService;
    }

    public function getAllTicketsForUser(Request $request)
    {
        return $this->userdashboardService->getAllTicketsForUser($request);
    }

    public function getOneTicketsForUser($id)
    {
        return $this->userdashboardService->getOneTicketsForUser($id);
    }

    public function cancelTicket(CancelTicketRequest $request)
    {
        return $this->userdashboardService->cancelTicket($request);
    }

    public function changePriceOfTicket(ChangePriceTicketRequest $request)
    {
        return $this->userdashboardService->changePriceOfTicket($request);
    }

    public function changeimage(ChangeImageTicketRequest $request)
    {
        return $this->userdashboardService->changeimage($request);
    }

    public function getAllTicketsSalledForUser()
    {
        return $this->userdashboardService->getAllTicketsSalledForUser();
    }

    public function getOneTicketSalledForUser($id)
    {
        return $this->userdashboardService->getOneTicketSalledForUser($id);
    }

    public function getAllTicketsWantToSalle()
    {
        return $this->userdashboardService->getAllTicketsWantToSalle();
    }

    public function getOneTicketsWantToSalle($id)
    {
        return $this->userdashboardService->getOneTicketsWantToSalle($id);
    }

    public function getAllNewTickets()
    {
        return $this->userdashboardService->getAllNewTickets();
    }

    public function getOneNewTickets($id)
    {
        return $this->userdashboardService->getOneNewTickets($id);
    }

    public function acceptReject(AcceptRejectRequest $request)
    {
        return $this->userdashboardService->acceptReject($request);
    }

    public function getAllOrderWallet()
    {
        return $this->userdashboardService->getAllOrderWallet();
    }

    public function getOnerderWallet($id)
    {
        return $this->userdashboardService->getOnerderWallet($id);
    }

}
