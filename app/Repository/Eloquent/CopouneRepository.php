<?php

namespace App\Repository\Eloquent;

use App\Models\Copoune;
use App\Repository\CopouneRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CopouneRepository extends Repository implements CopouneRepositoryInterface
{
    protected Model $model;

    public function __construct(Copoune $model)
    {
        parent::__construct($model);
    }
    public function getRigthCopoune($column1,$value,$column2)
    {
        return $this->model::query()->where($column1,$value)->where($column2 , '>' , 0)->first();
    }
    public function checkItem($column,$value)
    {
        return $this->model::query()->where($column,$value)->exists();
    }
}
