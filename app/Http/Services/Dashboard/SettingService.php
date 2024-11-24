<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\SettingRequest;
use App\Repository\SettingRepositoryInterface;
use App\Traits\GeneralTrait;

class SettingService
{
    use GeneralTrait;
    protected SettingRepositoryInterface $settingRepository;
    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getpage()
    {
        $setting = $this->settingRepository->getFirst();
        return view('dashboard.setting.info' , ['setting' => $setting]);
    }

    public function update(SettingRequest $request)
    {
        $setting = $this->settingRepository->getFirst();
        $data = $request->input();
        if($request->hasFile('homecover'))
        {
            $homecover = $this->handle('homecover', 'settings');
            $data = array_merge($data,["homecover"=>$homecover]);
        }
        if($request->hasFile('sitelogo'))
        {
            $sitelogo = $this->handle('sitelogo', 'settings');
            $data = array_merge($data,["sitelogo"=>$sitelogo]);
        }
        $this->settingRepository->update($setting->id,$data);
        return redirect()->route('setting')->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

}
