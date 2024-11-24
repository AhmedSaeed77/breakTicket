<?php

namespace App\Repository\Eloquent;

use App\Models\CopouneEvents;
use App\Repository\CopouneEventsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CopouneEventsRepository extends Repository implements CopouneEventsRepositoryInterface
{
    protected Model $model;

    public function __construct(CopouneEvents $model)
    {
        parent::__construct($model);
    }

    public  function  deleteItems($coulumn,$value)
    {
        $this->model::query()->where($coulumn, $value)->delete();
    }
}
