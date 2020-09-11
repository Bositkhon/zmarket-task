<?php

namespace App\Http\Controllers;

use App\Http\Requests\DerecogniseFromBalanceFormRequest;
use App\Http\Requests\ReplenishWalletFormRequest;
use App\Interfaces\Repositories\WalletRepositoryInterface;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class WalletController extends Controller
{

    /**
     * Repository related to this controller
     *
     * @var WalletRepositoryInterface
     */
    protected $repository;

    /**
     * Service related to this controller
     *
     * @var WalletService
     */
    protected $service;

    public function __construct(WalletRepositoryInterface $repository, WalletService $service)
    {
        $this->middleware('auth');

        $this->repository = $repository;
        $this->service = $service;
    }

    public function replenish(ReplenishWalletFormRequest $request)
    {
        $wallet = Auth::user()->wallet;
    
        Gate::authorize('update-wallet', $wallet);

        $amount = $request->get('amount');

        $this->repository->incrementBalance($wallet, $amount);

        return back()->with([
                'success' => __('messages.replenish_success')
            ]);
    }

    public function derecognise(DerecogniseFromBalanceFormRequest $request)
    {
        $wallet = Auth::user()->wallet;

        Gate::authorize('update-wallet', $wallet);

        $amount = $request->get('amount');
        
        $this->repository->decrementBalance($wallet, $amount);

        return back()->with([
            'success' => __('messages.derecognise_success')
        ]);
    }

}
