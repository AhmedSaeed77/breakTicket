<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\SocialLoginService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    private SocialLoginService $socialService;

    public function __construct(SocialLoginService $socialService)
    {
        $this->socialService = $socialService;
    }

    public function redirect($provider)
    {
        return $this->socialService->redirect($provider);
    }


    public function Callback($provider)
    {
        return $this->socialService->Callback($provider);
    }

    public function checkSocial(Request $request)
    {
        return $this->socialService->checkSocial($request);
    }
}
