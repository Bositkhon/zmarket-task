<?php

namespace App\Providers;

use App\Interfaces\Repositories\DepositRepositoryInterface;
use App\Models\User;
use App\Models\Wallet;
use App\Observers\UserObserver;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\WalletRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Repositories\WalletRepositoryInterface;
use App\Models\Deposit;
use App\Observers\DepositObserver;
use App\Repositories\DepositRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DepositRepositoryInterface::class, DepositRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Deposit::observe(DepositObserver::class);
    }
}
