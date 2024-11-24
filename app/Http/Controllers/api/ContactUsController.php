<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\ContactUsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\ContactUsRequest;

class ContactUsController extends Controller
{
    private ContactUsService $contactService;

    public function __construct(ContactUsService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function store(ContactUsRequest $request)
    {
        return $this->contactService->store($request);
    }

    public function getContactusData()
    {
        return $this->contactService->getContactusData();
    }
}
