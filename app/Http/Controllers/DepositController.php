<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\DepositService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InvestToDepositFormRequest;
use App\Interfaces\Repositories\DepositRepositoryInterface;

class DepositController extends Controller
{
    protected $repository;

    protected $service;

    public function __construct(DepositRepositoryInterface $repository, DepositService $service)
    {
        $this->middleware('auth');
        $this->repository = $repository;
        $this->service = $service;
    }

    public function invest(InvestToDepositFormRequest $request, UserService $userService)
    {
        $this->repository->createDepositForUser(Auth::user(), $request->validated());

        return back()->with([
            'success' => __('messages.invest_success')
        ]);
    }
}
