<?php

namespace App\Repository\Eloquent;

use App\Models\Admin;
use App\Repository\AdminRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AdminRepository extends Repository implements AdminRepositoryInterface
{
    protected Model $model;

    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

}
