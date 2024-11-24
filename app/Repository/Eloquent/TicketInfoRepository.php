<?php

namespace App\Repository\Eloquent;

use App\Models\TicketInfo;
use App\Repository\TicketInfoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TicketInfoRepository extends Repository implements TicketInfoRepositoryInterface
{
    protected Model $model;

    public function __construct(TicketInfo $model)
    {
        parent::__construct($model);
    }
    public function getCountItems($column1,$value1,$column2,$value2)
    {
        return $this->model::query()->select(['*'])->where($column1, $value1)->where($column2, $value2)->count();
    }
}
