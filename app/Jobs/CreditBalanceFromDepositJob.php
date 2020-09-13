<?php

namespace App\Jobs;

use App\Models\Deposit;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Services\DepositService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Interfaces\Repositories\DepositRepositoryInterface;
use Illuminate\Support\Facades\Redis;

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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Deposit $deposit)
    {
        $this->deposit = $deposit;
    }

    public $tries = 10;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DepositRepositoryInterface $repository, DepositService $service)
    {
        $share = $service->getShare($this->deposit);

        $repository->accrue($this->deposit, $share);

        if ($this->attempts() != $this->tries) {
            $this->release(5);            
        }
    }

    public function getDeposit() : Deposit
    {
        return $this->deposit;
    }

}
