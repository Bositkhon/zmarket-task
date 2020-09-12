<?php

namespace App\Jobs;

use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use App\Services\DepositService;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Interfaces\Repositories\DepositRepositoryInterface;
use App\Interfaces\Repositories\WalletRepositoryInterface;
use Illuminate\Support\Facades\App;

class CreditBalanceFromDepositJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Deposit model binded to the job
     *
     * @var Deposit
     */
    protected $deposit;

    /**
     * Timeout value the job to be dispatched
     *
     * @var integer
     */
    public $timeout = 60;

    /**
     * The number of dispatches needs to be done
     *
     * @var integer
     */
    public $tries = 10;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Deposit $deposit)
    {
        $this->deposit = $deposit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DepositRepositoryInterface $repository, DepositService $service)
    {
        $share = $service->getShare($this->deposit);

        $repository->accrue($this->deposit, $share);

        $repository->incrementWalletBalanceBy($this->deposit, $share);

        $repository->saveAccrueTransaction($this->deposit, $share);
    }
}
