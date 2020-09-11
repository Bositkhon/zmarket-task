<?php

namespace App\Repositories;

use App\Interfaces\Repositories\WalletRepositoryInterface;
use App\Models\Wallet;

class WalletRepository extends BaseEloquentRepository implements WalletRepositoryInterface
{

    public function __construct(Wallet $wallet)
    {
        parent::__construct($wallet);
    }

    /**
     * Increments the balance of a wallet
     *
     * @param Wallet $wallet
     * @param double|float|int $amount
     * @return void
     */
    public function incrementBalance(Wallet $wallet, $amount): void
    {
        $wallet->increment('balance', $amount);
    }

    /**
     * Decrements the balance of a wallet
     *
     * @param Wallet $wallet
     * @param double|float|int $amount
     * @return void
     */
    public function decrementBalance(Wallet $wallet, $amount): void
    {
        $wallet->decrement('balance', $amount);
    }
}