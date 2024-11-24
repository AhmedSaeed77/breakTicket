<?php

namespace App\Http\Services\api;
use App\Traits\GeneralTrait;
use App\Http\Resources\api\AboutResource;
use App\Http\Resources\api\FooterResource;
use App\Http\Resources\api\UserBankInfo;
use App\Repository\SettingRepositoryInterface;
use Illuminate\Http\Request;

class SettingService
{
    use GeneralTrait;
    protected SettingRepositoryInterface $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }
    public function getwhoAreYouData()
    {
        $setting = $this->settingRepository->getFirst();
        $setting_data = new AboutResource($setting);
        return $this->returnData('data',$setting_data);
    }

    public function getFooterData()
    {
        $setting = $this->settingRepository->getFirst();
        $setting_data = new FooterResource($setting);
        return $this->returnData('data',$setting_data);
    }

    public function getBankInfo()
    {
        $setting = $this->settingRepository->getFirst();
        $setting_data = new UserBankInfo($setting);
        return $this->returnData('data',$setting_data);
    }
}
