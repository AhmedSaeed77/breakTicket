<?php

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends Repository implements OrderRepositoryInterface
{
    protected Model $model;

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
    public function getItem(array $coloumns = [], array $values = [])
    {
        return $this->model::query()->select(['*'])->where(array_combine($coloumns, $values))->first();
    }

    public function getAllOrders($columns = ['*'],array $relations = [] ,$orderBy = 'desc' ,int $perPage = 10,$search = '')
    {
        return $this->model::query()->has('payments')->select($columns)->with($relations)->orderBy('id' , $orderBy)->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('order_number', 'like', $searchTerm);
        })
            ->paginate($perPage);
    }

    public function filterorder2($coloumn,array $arr=[])
    {
        return $this->model::query()->select(['*'])->whereIn($coloumn, $arr)->get();
    }

    public function count()
    {
        return $this->model::query()->count();
    }

    public function max($value)
    {
        return $this->model::query()->max($value);
    }
    public  function getlatestOrder($column1,$value,$column2)
    {
        return $this->model::query()->where($column1, $value)->latest($column2)->first();
    }
}
