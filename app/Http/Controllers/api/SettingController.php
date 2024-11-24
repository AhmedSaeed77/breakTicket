<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\SettingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function getwhoAreYouData()
    {
        return $this->settingService->getwhoAreYouData();
    }

    public function getFooterData()
    {
        return $this->settingService->getFooterData();
    }

    public function getBankInfo()
    {
        return $this->settingService->getBankInfo();
    }
}
