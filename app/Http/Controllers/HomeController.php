<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReplenishWalletFormRequest;
use App\Interfaces\Repositories\DepositRepositoryInterface;

class HomeController extends Controller
{

    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DepositRepositoryInterface $repository)
    {
        $this->middleware('auth');

        $this->repository = $repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $deposits = Auth::user()->deposits;
        $transactions = Auth::user()->transactions;
        return view('home', compact('deposits', 'transactions'));
    }
}
