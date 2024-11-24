<?php

namespace App\Repository\Eloquent;

use App\Models\Setting;
use App\Repository\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SettingRepository extends Repository implements SettingRepositoryInterface
{
    protected Model $model;

    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

}
