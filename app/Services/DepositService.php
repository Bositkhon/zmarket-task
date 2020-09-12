<?php

namespace App\Services;

use App\Models\Deposit;

class DepositService
{

    /**
     * Calculates and returns the share of a deposit
     *
     * @param Deposit $deposit
     * @return double
     */
    public function getShare(Deposit $deposit)
    {
        return ($deposit->percentage * $deposit->invested_amount) / 100;
    }

}
