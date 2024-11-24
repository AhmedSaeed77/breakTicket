<?php

namespace App\Http\Services\api;
use App\Repository\PolicyRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Resources\api\PolicyResource;

class PolicyService
{
    use GeneralTrait;
    protected PolicyRepositoryInterface $policyRepository;
    public function __construct(PolicyRepositoryInterface $policyRepository)
    {
        $this->policyRepository = $policyRepository;
    }
    public function getAllPolicies()
    {
        $policies = $this->policyRepository->getAll();
        $policies_data = PolicyResource::collection($policies);
        return $this->returnData('data',$policies_data);
    }
}
