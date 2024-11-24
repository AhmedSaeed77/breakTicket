<?php

namespace App\Repository;

interface OrderTicketInfoRepositoryInterface extends RepositoryInterface
{
    public function filterorder($coloumn,array $arr=[]);
}
