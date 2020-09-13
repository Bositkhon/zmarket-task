<?php

namespace App\Console\Commands;

use App\Interfaces\Repositories\DepositRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Jobs\CreditBalanceFromDeposit;
use App\Jobs\CreditBalanceFromDepositJob;
use App\Models\Deposit;
use App\Services\DepositService;
use Illuminate\Support\Facades\Queue;

class CreditUsersBalanceFromDepositCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:balance {deposit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Credits all users balances from their deposits';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DepositRepositoryInterface $depositRepository, DepositService $depositService)
    {
        $deposit = Deposit::find($this->argument('deposit'));
        
        dispatch(new CreditBalanceFromDepositJob($deposit))
            ->chain([
                function () use ($depositRepository, $deposit) {
                    $depositRepository->markStatusAsClosed($deposit);
                },
            ]);


        return 0;
    }
}
