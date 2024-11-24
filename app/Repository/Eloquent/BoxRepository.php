<?php

namespace App\Repository\Eloquent;

use App\Models\Box;
use App\Repository\BoxRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BoxRepository extends Repository implements BoxRepositoryInterface
{
    protected Model $model;

    public function __construct(Box $model)
    {
        parent::__construct($model);
    }

}
