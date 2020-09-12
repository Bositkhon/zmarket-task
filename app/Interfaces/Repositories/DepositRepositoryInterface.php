<?php

namespace App\Interfaces\Repositories;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface DepositRepositoryInterface
{
    public function create(array $attributes) : Model;
    public function saveCreatedTransaction(Deposit $deposit) : Transaction;
    public function saveAccrueTransaction(Deposit $deposit, $share) : Transaction;
    public function getActiveDeposits() : Collection;
    public function createDepositForUser(User $user, array $attributes) : Deposit;
    public function accrue(Deposit $deposit, $share) : void;
    public function setStatus(Deposit $deposit, int $status) : void;
    public function decrementWalletBalanceBy(Deposit $deposit, $amount) : void;
    public function incrementWalletBalanceBy(Deposit $deposit, $amount) : void;
}