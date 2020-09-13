<?php

namespace App\Repositories;

use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Repositories\DepositRepositoryInterface;
use App\Interfaces\Repositories\WalletRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

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
     * Retrieves all active deposits
     *
     * @return Collection
     */
    public function getActiveDeposits(): Collection
    {
        return Deposit::active()->get();
    }

    /**
     * Creates deposit model for a given user
     *
     * @param User $user
     * @param array $attributes
     * @return Deposit
     */
    public function createDepositForUser(User $user, array $attributes) : Deposit
    {
        return DB::transaction(function () use ($user, $attributes) {
            return $user
                ->deposits()
                ->create(array_merge(['wallet_id' => $user->wallet->id], $attributes));
        });
    }

    /**
     * Decreases wallet balance by given amount
     *
     * @param Deposit $deposit
     * @param int $amount
     * @return void
     */
    public function decrementWalletBalanceBy(Deposit $deposit, $amount) : void
    {
        DB::transaction(function () use ($deposit, $amount) {
            $deposit->wallet->decrement('balance', $amount);
        });
    }

    /**
     * Increases wallet balance by given amount
     *
     * @param Deposit $deposit
     * @return void
     */
    public function incrementWalletBalanceBy(Deposit $deposit, $amount) : void
    {
        DB::transaction(function () use ($deposit, $amount) {
            $deposit->wallet->increment('balance', $amount);
        });
    }

    /**
     * Undocumented function
     *
     * @param Deposit $deposit
     * @return Transaction
     */
    public function saveCreatedTransaction(Deposit $deposit) : Transaction
    {
        return DB::transaction(function () use ($deposit) {
            return $deposit->transactions()->create([
                'type' => Transaction::TYPE_CREATE_DEPOSIT,
                'user_id' => $deposit->user_id,
                'wallet_id' => $deposit->wallet_id,
                'deposit_id' => $deposit->id,
                'amount' => $deposit->invested_amount
            ]);
        });
    }

    public function accrue(Deposit $deposit, $share) : void
    {
        DB::transaction(function () use ($deposit, $share) {
            $deposit->increment('accrue_times');
            $this->incrementWalletBalanceBy($deposit, $share);
            $this->saveAccrueTransaction($deposit, $share);
        });
    }

    public function saveAccrueTransaction(Deposit $deposit, $share) : Transaction
    {
        return Db::transaction(function () use ($deposit, $share) {
            return $deposit->transactions()->create([
                'type' => Transaction::TYPE_ACCRUE,
                'user_id' => $deposit->user_id,
                'wallet_id' => $deposit->wallet_id,
                'deposit_id' => $deposit->id,
                'amount' => $share
            ]);
        });
    }

    public function saveStatusClosedTransaction(Deposit $deposit)
    {
        return Db::transaction(function () use ($deposit) {
            return $deposit->transactions()->create([
                'type' => Transaction::TYPE_CLOSE_DEPOSIT,
                'user_id' => $deposit->user_id,
                'wallet_id' => $deposit->wallet_id,
                'deposit_id' => $deposit->id,
                'amount' => 0
            ]);
        });
    }

    public function markStatusAsClosed(Deposit $deposit): void
    {
        DB::transaction(function () use ($deposit) {
            $deposit->update([
                'status' => Deposit::STATUS_CLOSED
            ]);
            $this->saveStatusClosedTransaction($deposit);
        });
    }

}