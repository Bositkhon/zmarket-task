<?php

namespace App\Jobs;

use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use App\Services\DepositService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class CreditBalanceFromDeposit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Deposit model binded to the job
     *
     * @var \App\Models\Deposit
     */
    protected $deposit;

    /**
     * Service corresponding to the model
     *
     * @var \App\Services\DepositService
     */
    protected $service;


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
    public function __construct(DepositService $service, Deposit $deposit)
    {
        $this->deposit = $deposit;
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $deposit = $this->deposit;
        $wallet = $this->deposit->wallet;

        $share = $this->service->getShare($deposit);
        
        DB::transaction(function () use ($wallet, $deposit, $share) {
            $wallet->increment('balance', $share);
            $deposit->increment('accrue_times');
        });
    }
}
