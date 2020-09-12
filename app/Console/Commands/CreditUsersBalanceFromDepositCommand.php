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

class CreditUsersBalanceFromDepositCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Credits all users balances from their deposits';

    protected $depositRepository;

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
        $deposits = $depositRepository->getActiveDeposits();

        $deposits->each(function ($deposit) use ($depositRepository, $depositService) {
            $this->line("Credit info:");
            $this->line("User: {$deposit->user->name}");
            $this->line("Share: {$depositService->getShare($deposit)}");

            dispatch(new CreditBalanceFromDepositJob($deposit));

            $depositRepository->setStatus($deposit, Deposit::STATUS_CLOSED);
        });

        return 0;
    }
}
