<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Wallet;
use App\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseEloquentRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Creates a new wallet for a user
     *
     * @param User $user
     * @param array $attributes
     * @return Wallet
     */
    public function createWalletForUser(User $user, array $attributes = []) : Wallet
    {
        return DB::transaction(function () use ($user, $attributes) {
            return $user->wallet()->create($attributes);
        });
    }

    public function all() : Collection
    {
        return User::all();
    }

}
