<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\SettingRequest;
use App\Http\Services\Dashboard\SettingService;

class SettingController extends Controller
{
    private SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function getpage()
    {
        return $this->settingService->getpage();
    }

    public function update(SettingRequest $request)
    {
        return $this->settingService->update($request);
    }

}
