<?php

namespace App\Providers;

use App\Interfaces\Repositories\WalletRepositoryInterface;
use App\Models\User;
use App\Models\Wallet;
use App\Observers\UserObserver;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
