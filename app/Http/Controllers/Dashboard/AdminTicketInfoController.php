<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Requests\Dashboard\AdminTicketInfoRequest;
use App\Http\Services\Dashboard\AdminTicketInfoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminTicketInfoController extends Controller
{
    private AdminTicketInfoService $adminticketinfoService;

    public function __construct(AdminTicketInfoService $adminticketinfoService)
    {
        $this->adminticketinfoService = $adminticketinfoService;
    }

    public function create($id)
    {
        return $this->adminticketinfoService->create($id);
    }

    public function store(AdminTicketInfoRequest $request,$id)
    {
        return $this->adminticketinfoService->store($request,$id);
    }

    public function edit($ticket_id,$id)
    {
        return $this->adminticketinfoService->edit($ticket_id,$id);
    }

    public function update(AdminTicketInfoRequest $request,$ticket_id,$id)
    {
        return $this->adminticketinfoService->update($request,$ticket_id,$id);
    }

    public function destroy($ticket_id,$id)
    {
        return $this->adminticketinfoService->delete($ticket_id,$id);
    }
}
