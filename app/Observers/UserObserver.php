<?php

namespace App\Observers;

use App\Models\User;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Repositories\WalletRepositoryInterface;

class UserObserver
{

    /**
     * User repository
     *
     * @var UserRepositoryInterface
     */
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $this->repository->createWalletForUser($user);
    }
}
