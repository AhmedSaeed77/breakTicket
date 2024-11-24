<?php

namespace App\Repository;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getItem(array $coloumns = [], array $values = []);

    public function getAllOrders();

    public function filterorder2($coloumn,array $arr=[]);

    public function count();
    public function max($value);
    public  function getlatestOrder($column1,$value,$column2);
}
