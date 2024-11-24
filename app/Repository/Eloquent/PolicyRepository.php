<?php

namespace App\Repository\Eloquent;

use App\Models\Policy;
use App\Repository\PolicyRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PolicyRepository extends Repository implements PolicyRepositoryInterface
{
    protected Model $model;

    public function __construct(Policy $model)
    {
        parent::__construct($model);
    }

}
