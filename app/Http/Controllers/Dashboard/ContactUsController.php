<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\ContactUsRequest;
use App\Http\Services\Dashboard\ContactUsService;


class ContactUsController extends Controller
{
    private ContactUsService $contactusService;

    public function __construct(ContactUsService $contactusService)
    {
        $this->contactusService = $contactusService;
    }

    public function index()
    {
        return $this->contactusService->index();
    }

    public function destroy($id)
    {
        return $this->contactusService->delete($id);
    }
}
