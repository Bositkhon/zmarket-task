<?php

namespace App\Interfaces\Repositories;

use App\Models\Wallet;

interface WalletRepositoryInterface
{

    /**
     * Increments the field by value
     *
     * @param Wallet $wallet
     * @param double|float|int $value
     * @return void
     */
    public function incrementBalance(Wallet $wallet, $amount) : void;

    public function decrementBalance(Wallet $wallet, $amount) : void;

}