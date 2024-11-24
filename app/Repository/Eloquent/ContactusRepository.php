<?php

namespace App\Repository\Eloquent;

use App\Models\Contactus;
use App\Repository\ContactusRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ContactusRepository extends Repository implements ContactusRepositoryInterface
{
    protected Model $model;

    public function __construct(Contactus $model)
    {
        parent::__construct($model);
    }

}
