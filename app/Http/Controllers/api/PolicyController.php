<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\PolicyService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    private PolicyService $policyService;

    public function __construct(PolicyService $policyService)
    {
        $this->policyService = $policyService;
    }

    public function getAllPolicies()
    {
        return $this->policyService->getAllPolicies();
    }
}
