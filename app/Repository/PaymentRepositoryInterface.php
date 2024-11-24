<?php

namespace App\Repository;

interface PaymentRepositoryInterface extends RepositoryInterface
{
    public function getAllPayments();
}
