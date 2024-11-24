<?php

namespace App\Repository\Eloquent;

use App\Models\subcategory;
use App\Repository\subcategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class subcategoryRepository extends Repository implements subcategoryRepositoryInterface
{
    protected Model $model;

    public function __construct(subcategory $model)
    {
        parent::__construct($model);
    }
    public function getAllsubcategories($id)
    {
        return $this->model::query()->select(['*'])->where('event_id', $id)->pluck("name_en","id");
    }
}
