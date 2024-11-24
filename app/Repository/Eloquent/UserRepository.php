<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected Model $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function checkItem($byColumn, $value)
    {
        return $this->model::query()->where($byColumn, $value)->first();
    }

    public function getAllUsers($columns = ['*'],array $relations = [] ,$orderBy = 'desc' ,int $perPage = 10,$search = '')
    {
        return $this->model::query()->select($columns)->with($relations)->orderBy('id' , $orderBy)->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name', 'like', $searchTerm)
                ->orWhere('email', 'like', $searchTerm)
                ->orWhere('phone', 'like', $searchTerm);
        })
        ->paginate($perPage);
    }

}
