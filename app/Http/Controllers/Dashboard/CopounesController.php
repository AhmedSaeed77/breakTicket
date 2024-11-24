<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Services\Dashboard\CopounesService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\CopouneRequest;

class CopounesController extends Controller
{
    private CopounesService $copounesService;

    public function __construct(CopounesService $copounesService)
    {
        $this->copounesService = $copounesService;
    }

    public function index()
    {
        return $this->copounesService->index();
    }

    public function create()
    {
        return $this->copounesService->create();
    }

    public function store(CopouneRequest $request)
    {
        return $this->copounesService->store($request);
    }

    public function edit($id)
    {
        return $this->copounesService->edit($id);
    }

    public function update(CopouneRequest $request,$id)
    {
        return $this->copounesService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->copounesService->delete($id);
    }
}
