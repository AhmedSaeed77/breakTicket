<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends Repository implements CategoryRepositoryInterface
{
    protected Model $model;

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

}
