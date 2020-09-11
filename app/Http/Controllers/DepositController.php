<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestToDepositFormRequest;
use Illuminate\Http\Request;
use App\Services\DepositService;
use App\Interfaces\Repositories\DepositRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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

    public function invest(InvestToDepositFormRequest $request)
    {
        $wallet = Auth::user()->wallet;
    }
}
