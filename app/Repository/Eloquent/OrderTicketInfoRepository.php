<?php

namespace App\Repository\Eloquent;

use App\Models\OrderTicketInfo;
use App\Repository\OrderTicketInfoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OrderTicketInfoRepository extends Repository implements OrderTicketInfoRepositoryInterface
{
    protected Model $model;

    public function __construct(OrderTicketInfo $model)
    {
        parent::__construct($model);
    }
    public function filterorder($coloumn,array $arr=[])
    {
        return $this->model::query()->select(['*'])->whereIn($coloumn, $arr)->pluck('order_ticket_id')->toArray();
    }
}
