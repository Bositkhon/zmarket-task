<?php

namespace App\Observers;

use App\Models\Deposit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Repositories\WalletRepository;
use App\Repositories\DepositRepository;
use App\Interfaces\Repositories\WalletRepositoryInterface;
use App\Interfaces\Repositories\DepositRepositoryInterface;
use App\Interfaces\Repositories\TransactionRepositoryInterface;

class DepositObserver
{

    /**
     * Deposit repository
     *
     * @var DepositRepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param DepositRepositoryInterface $repository
     */
    public function __construct(DepositRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the deposit "created" event.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return void
     */
    public function created(Deposit $deposit)
    {
        $this->repository->decrementWalletBalanceBy($deposit, $deposit->invested_amount);
        
        $this->repository->saveCreatedTransaction($deposit);
    }

}
