<?php

namespace App\Interfaces\Repositories;

use App\Models\Deposit;

interface DepositRepositoryInterface
{
    /**
     * Creates a model and stores the record in the database
     *
     * @param array $attributes
     * @return Deposit
     */
    public function create(array $attributes) : Deposit;
}