<?php 

namespace App\Providers;

use App\Interfaces\Repositories\DepositRepositoryInterface;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use App\Jobs\CreditBalanceFromDepositJob;
use Illuminate\Queue\Events\JobProcessed;

class QueueServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $repository = $this->app->make(DepositRepositoryInterface::class);
        Queue::after(function (JobProcessed $event) use ($repository) {
            if ($event->job instanceof CreditBalanceFromDepositJob) {
                $deposit = $event->job->getDeposit();
                $repository->markAsClosed($deposit);
            }
        });
    }
}