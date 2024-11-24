<?php

namespace App\Repository\Eloquent;

use App\Models\ResetPassword;
use App\Repository\ResetPasswordRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ResetPasswordRepository extends Repository implements ResetPasswordRepositoryInterface
{
    protected Model $model;

    public function __construct(ResetPassword $model)
    {
        parent::__construct($model);
    }

    public function deleteItem($column,$value)
    {
        $this->model::query()->where($column, $value)->delete();
    }

    public function checkItem($byColumn, $value)
    {
        return $this->model::query()->where($byColumn, $value)->first();
    }
}
