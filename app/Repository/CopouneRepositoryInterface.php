<?php

namespace App\Repository;

interface CopouneRepositoryInterface extends RepositoryInterface
{
    public function getRigthCopoune($column1,$value,$column2);
    public function checkItem($column,$value);

}
