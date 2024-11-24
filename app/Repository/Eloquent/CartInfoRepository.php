<?php

namespace App\Repository\Eloquent;

use App\Models\CartInfo;
use App\Repository\CartInfoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CartInfoRepository extends Repository implements CartInfoRepositoryInterface
{
    protected Model $model;

    public function __construct(CartInfo $model)
    {
        parent::__construct($model);
    }

}
