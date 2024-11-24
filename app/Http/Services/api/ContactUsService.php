<?php

namespace App\Http\Services\api;
use App\Http\Requests\api\ContactUsRequest;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Repository\ContactusRepositoryInterface;
use App\Repository\SettingRepositoryInterface;
use App\Http\Resources\api\ContactUsResource;

class ContactUsService
{
    use GeneralTrait;
    protected ContactusRepositoryInterface $contactRepository;
    protected SettingRepositoryInterface $settingRepository;
    public function __construct(ContactusRepositoryInterface $contactRepository , SettingRepositoryInterface $settingRepository)
    {
        $this->contactRepository = $contactRepository;
        $this->settingRepository = $settingRepository;
    }
    public function store(ContactUsRequest $request)
    {
        $data = array_merge($request->input());
        $this->contactRepository->create($data);
        return $this->returnSuccessMassage(__('site.The_Message_Is_Sent'));
    }

    public function getContactusData()
    {
        $setting = $this->settingRepository->getFirst();
        $setting_data = new ContactUsResource($setting);
        return $this->returnData('data',$setting_data);
    }
}
