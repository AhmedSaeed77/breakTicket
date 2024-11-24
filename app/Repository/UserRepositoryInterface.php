<?php

namespace App\Repository;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function checkItem($byColumn,$value);

    public function getAllUsers();
}
