<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\WalletController;

// Rota para a página inicial (página de boas-vindas)
Route::get('/', function () {
    return view('welcome');
});

// Grupo de rotas protegidas por autenticação e verificação de sessão
Route::middleware([
    'auth:sanctum',  // Middleware de autenticação via Sanctum
    config('jetstream.auth_session'),  // Middleware de verificação de sessão do Jetstream
    'verified',  // Middleware para garantir que o e-mail do usuário está verificado
])->group(function () {
    // Rota para o dashboard do usuário autenticado
    // Exibe a visão 'dashboard' para usuários autenticados
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Rotas para exibir gráficos
// Exibe todos os gráficos disponíveis
Route::get('/graphs', [GraphController::class, 'index'])->name('graphs.index');
// Exibe um gráfico específico baseado no tipo e id fornecidos
Route::get('/graphs/{type}/{id}', [GraphController::class, 'show'])->name('graphs.show');

Route::middleware(['auth'])->group(function () {
    // Rota para o dashboard, gerenciada pelo controlador DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas para gestão de ações
    Route::resource('stocks', StockController::class);
    // Exibe uma lista de todas as ações
    Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
    // Exibe o formulário para criar uma nova ação
    Route::get('stocks/create', [StockController::class, 'create'])->name('stocks.create');
    // Armazena uma nova ação no banco de dados
    Route::post('stocks', [StockController::class, 'store'])->name('stocks.store');
    // Exibe o formulário para editar uma ação existente
    Route::get('stocks/{stock}/edit', [StockController::class, 'edit'])->name('stocks.edit');
    // Atualiza uma ação existente no banco de dados
    Route::put('stocks/{stock}', [StockController::class, 'update'])->name('stocks.update');
    // Exibe o formulário para adicionar preços a uma ação
    Route::get('stocks/{stock}/add-prices', [StockController::class, 'addPricesForm'])->name('stocks.add-prices-form');
    // Armazena os preços adicionados a uma ação
    Route::post('stocks/{stock}/add-prices', [StockController::class, 'storePrices'])->name('stocks.store-prices');
    // Deleta uma ação existente
    Route::delete('stocks/{stock}', [StockController::class, 'destroy'])->name('stocks.destroy');
    // Exibe detalhes de uma ação específica
    Route::get('stocks/{stock}', [StockController::class, 'show'])->name('stocks.show');

    // Rotas para gestão de fundos
    Route::resource('funds', FundController::class);
    // Exibe o formulário para criar preços de um fundo
    Route::get('/funds/{id}/create-prices', [FundController::class, 'createPrices'])->name('funds.create-prices');
    // Exibe o formulário para adicionar preços a um fundo existente
    Route::get('funds/{fund}/add-prices', [FundController::class, 'addPricesForm'])->name('funds.add-prices-form');
    // Armazena os preços adicionados a um fundo
    Route::post('funds/{fund}/add-prices', [FundController::class, 'storePrices'])->name('funds.add-prices');
    // Exibe detalhes de um fundo específico
    Route::get('/funds/{id}', [FundController::class, 'show'])->name('funds.show');

    // Rotas para gestão de transações
    // Exibe o formulário para criar uma nova transação
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    // Armazena uma nova transação no banco de dados
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    // Processa a compra de ações ou fundos
    Route::post('/transactions/buy', [TransactionController::class, 'buy'])->name('transactions.buy');
    // Processa a venda de ações ou fundos
    Route::post('/transactions/sell', [TransactionController::class, 'sell'])->name('transactions.sell');
    // Exibe uma lista de todas as transações
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // Rotas para gestão da carteira do usuário
    // Exibe a visão da carteira com informações do saldo e transações
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    // Exibe o formulário para adicionar saldo à carteira
    Route::get('/wallet/add-balance', [WalletController::class, 'showAddBalanceForm'])->name('wallet.showAddBalanceForm');
    // Adiciona saldo à carteira do usuário
    Route::post('/wallet/add-balance', [WalletController::class, 'addBalance'])->name('wallet.addBalance');
});
