<?php

namespace App\Repositories;

use App\Interfaces\Repositories\DepositRepositoryInterface;
use App\Models\Deposit;

class DepositRepository extends BaseEloquentRepository implements DepositRepositoryInterface
{
    /**
     *
     * @param Deposit $deposit
     */
    public function __construct(Deposit $deposit)
    {
        $this->model = $deposit;
    }

    /**
     * Creates a model and stores the record in the database
     *
     * @param array $attributes
     * @return Deposit
     */
    public function create(array $attributes) : Deposit
    {
        return $this->model->create($attributes);
    }
}