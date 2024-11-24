<?php

namespace App\Repository;

interface ResetPasswordRepositoryInterface extends RepositoryInterface
{
    public function  deleteItem($column,$value);
    public function checkItem($byColumn, $value);
}
