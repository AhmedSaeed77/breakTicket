<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\BankService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\BankRequest;

class BankController extends Controller
{
    private BankService $bankService;

    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
    }

    public function getBankAccount()
    {
        return $this->bankService->getBankAccount();
    }

    public function store(BankRequest $request)
    {
        return $this->bankService->store($request);
    }

    public function update(BankRequest $request)
    {
        return $this->bankService->update($request);
    }
}
