<?php

namespace App\Interfaces\Repositories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function createWalletForUser(User $user, array $attributes = []) : Wallet;
    public function all() : Collection;
}
