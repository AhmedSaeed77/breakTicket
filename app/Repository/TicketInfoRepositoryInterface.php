<?php

namespace App\Repository;

interface TicketInfoRepositoryInterface extends RepositoryInterface
{
    public function getCountItems($column1,$value1,$column2,$value2);
}
