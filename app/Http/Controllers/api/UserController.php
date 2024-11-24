<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\UserRequest;
use App\Http\Requests\api\UserLoginRequest;
use App\Http\Requests\api\UserResetRequest;
use App\Http\Requests\api\UpdateProfileRequest;
use App\Http\Requests\api\UserConfirmRequest;
use App\Http\Requests\api\UserChangePasswordRequest;
use App\Http\Requests\api\UserChangePasswordDashboardRequest;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRequest $request)
    {
        return $this->userService->register($request);
    }

    public function login(UserLoginRequest $request)
    {
        return $this->userService->login($request);
    }

    public function reset(UserResetRequest $request)
    {
        return $this->userService->reset($request);
    }

    public function resetUserconfirm(UserConfirmRequest $request)
    {
        return $this->userService->resetUserconfirm($request);
    }

    public function changePassword(UserChangePasswordDashboardRequest $request)
    {
        return $this->userService->changePassword($request);
    }

    public function getuserprofile()
    {
        return $this->userService->getuserprofile();
    }

    public function updateprofile(UpdateProfileRequest $request)
    {
        return $this->userService->updateprofile($request);
    }

    public function getuserinfo()
    {
        return $this->userService->getuserinfo();
    }

    public function updatechangepassword(UserChangePasswordDashboardRequest $request)
    {
        return $this->userService->updatechangepassword($request);
    }
}
