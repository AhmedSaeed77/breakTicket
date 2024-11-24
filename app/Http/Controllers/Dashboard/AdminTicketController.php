<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Requests\Dashboard\AdminTicketRequest;
use App\Http\Services\Dashboard\AdminTicketService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    private AdminTicketService $adminticketService;

    public function __construct(AdminTicketService $adminticketService)
    {
        $this->adminticketService = $adminticketService;
    }

    public function index()
    {
        return $this->adminticketService->index();
    }

    public function create()
    {
        return $this->adminticketService->create();
    }

    public function store(AdminTicketRequest $request)
    {
        return $this->adminticketService->store($request);
    }

    public function show($id)
    {
        return $this->adminticketService->show($id);
    }

    public function edit($id)
    {
        return $this->adminticketService->edit($id);
    }

    public function update(AdminTicketRequest $request,$id)
    {
        return $this->adminticketService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->adminticketService->delete($id);
    }

    public function getAllBoxes($id)
    {
        return $this->adminticketService->getAllBoxes($id);
    }

    public function getAllsubcategories($id)
    {
        return $this->adminticketService->getAllsubcategories($id);
    }
}
