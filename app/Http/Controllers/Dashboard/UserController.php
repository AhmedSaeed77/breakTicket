<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\User;
use App\Models\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\UserRequest;
use App\Http\Services\Dashboard\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->index();
    }

    public function create()
    {
        return $this->userService->create();
    }

    public function store(UserRequest $request)
    {
        return $this->userService->store($request);
    }

    public function show($id)
    {
        return $this->userService->show($id);
    }

    public function edit($id)
    {
        return $this->userService->edit($id);
    }

    public function update(UserRequest $request,$id)
    {
        return $this->userService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->userService->delete($id);
    }

    public function getUserSales($id)
    {
        return $this->userService->getUserSales($id);
    }

    public function getUserPurchases($id)
    {
        return $this->userService->getUserPurchases($id);
    }

    public function ticketconvert($id)
    {
        return $this->userService->ticketconvert($id);
    }
}
