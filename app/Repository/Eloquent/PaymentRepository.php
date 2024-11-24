<?php

namespace App\Repository\Eloquent;

use App\Models\Payment;
use App\Repository\PaymentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PaymentRepository extends Repository implements PaymentRepositoryInterface
{
    protected Model $model;

    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    public function getAllPayments($columns = ['*'],array $relations = [] ,$orderBy = 'desc' ,int $perPage = 10,$search = '')
    {
        return $this->model::query()->select($columns)->with($relations)->orderBy('id' , $orderBy)->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('type', 'like', $searchTerm);
        })
            ->paginate($perPage);
    }

}
