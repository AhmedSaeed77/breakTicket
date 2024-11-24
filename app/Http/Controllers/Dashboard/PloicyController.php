<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\PolicyRequest;
use App\Http\Services\Dashboard\PolicyService;

class PloicyController extends Controller
{
    private PolicyService $policyService;

    public function __construct(PolicyService $policyService)
    {
        $this->policyService = $policyService;
    }

    public function index()
    {
        return $this->policyService->index();
    }

    public function create()
    {
        return $this->policyService->create();
    }

    public function store(PolicyRequest $request)
    {
        return $this->policyService->store($request);
    }

    public function show($id)
    {
        return $this->policyService->show($id);
    }

    public function edit($id)
    {
        return $this->policyService->edit($id);
    }

    public function update(PolicyRequest $request,$id)
    {
        return $this->policyService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->policyService->delete($id);
    }
}
