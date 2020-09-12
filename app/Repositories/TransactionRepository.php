<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Interfaces\Repositories\TransactionRepositoryInterface;

class TransactionRepository extends BaseEloquentRepository implements TransactionRepositoryInterface
{
    /**
     * Constructor
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }
}