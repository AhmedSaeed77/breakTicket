<?php

namespace App\Repository;

interface OrderTicketRepositoryInterface extends RepositoryInterface
{
    public function getwalletforuser($coloumn,$value);

    public function getordersticketsusersales($coloumn,$value);

    public function sumItems($coloumn,$value,$columnsum);

    public function filterorder1($coloumn,array $arr=[]);

    public function getCountNewOrders($coloumn,$value);
    public function getOrdersTickets($coloumn,$value);

    public function getAllWalet($coloumn,$value);
}
