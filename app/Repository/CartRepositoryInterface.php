<?php

namespace App\Repository;

interface CartRepositoryInterface extends RepositoryInterface
{
    public function sumCartPrice($coloumn,$value,$columnsum);
}
