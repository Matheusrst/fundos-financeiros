<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\FundController;
use App\http\Controllers\StockController;
use App\http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\WalletController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/graphs', [GraphController::class, 'index'])->name('graphs.index');
Route::get('/graphs/{type}/{id}', [GraphController::class, 'show'])->name('graphs.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas para ações
    Route::resource('stocks', StockController::class);

    // Rotas para fundos
    Route::resource('funds', FundController::class);
    Route::resource('funds', FundController::class);
    Route::get('/funds/{id}/create-prices', [FundController::class, 'createPrices'])->name('funds.create-prices');
    Route::post('/funds/add-prices', [FundController::class, 'addPrices'])->name('funds.add-prices');
    Route::get('/funds/{id}', [FundController::class, 'show'])->name('funds.show');


    // Rotas para transações
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::post('/transactions/buy', [TransactionController::class, 'buy'])->name('transactions.buy');
    Route::post('/transactions/sell', [TransactionController::class, 'sell'])->name('transactions.sell');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    //rotas da carteira
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/add-balance', [WalletController::class, 'showAddBalanceForm'])->name('wallet.showAddBalanceForm');
    Route::post('/wallet/add-balance', [WalletController::class, 'addBalance'])->name('wallet.addBalance');
});