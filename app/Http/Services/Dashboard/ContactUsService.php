<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\ContactUsRequest;
use App\Repository\ContactusRepositoryInterface;
use App\Traits\GeneralTrait;

class ContactUsService
{
    use GeneralTrait;
    protected ContactusRepositoryInterface $contactusRepository;
    public function __construct(ContactusRepositoryInterface $contactusRepository)
    {
        $this->contactusRepository = $contactusRepository;
    }

    public function index()
    {
        $contactuses = $this->contactusRepository->paginate();
        return view('dashboard.contactus.index' , ['contactuses' => $contactuses]);
    }

    public function delete($id)
    {
        $this->contactusRepository->delete($id);
        return redirect('contact-us')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }
}
