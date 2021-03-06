<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\DepositController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group([
    'as' => 'wallet.'
], function () {
    Route::post('/replenish', [WalletController::class, 'replenish'])->name('replenish');
    Route::post('/derecognise', [WalletController::class, 'derecognise'])->name('derecognise');
});

Route::group([
    'as' => 'deposit.'
], function () {
    Route::post('invest', [DepositController::class, 'invest'])->name('invest');
});