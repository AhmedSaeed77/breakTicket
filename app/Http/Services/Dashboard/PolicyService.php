<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\PolicyRequest;
use App\Repository\PolicyRepositoryInterface;
use App\Traits\GeneralTrait;

class PolicyService
{
    use GeneralTrait;
    protected PolicyRepositoryInterface $policyRepository;
    public function __construct(PolicyRepositoryInterface $policyRepository)
    {
        $this->policyRepository = $policyRepository;
    }

    public function index()
    {
        $policies = $this->policyRepository->paginate();
        return view('dashboard.policy.index' , ['policies' => $policies]);
    }

    public function create()
    {
        return view('dashboard.policy.create');
    }

    public function store(PolicyRequest $request)
    {
        $data = array_merge($request->input());
        $this->policyRepository->create($data);
        return redirect('policy')->with(["success"=>__('dashboard.recored created successfully.')]);
    }

    public function show($id)
    {
        $policy = $this->policyRepository->getById($id);
        return view('dashboard.policy.show' , ['policy' => $policy]);
    }

    public function edit($id)
    {
        $policy = $this->policyRepository->getById($id);
        return view('dashboard.policy.edit' , ['policy' => $policy]);
    }

    public function update(PolicyRequest $request,$id)
    {
        $policy = $this->policyRepository->getById($id);
        $data = array_merge($request->input());
        $this->policyRepository->update($policy->id,$data);
        return redirect('policy')->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function delete($id)
    {
        $this->policyRepository->delete($id);
        return redirect('policy')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }
}
