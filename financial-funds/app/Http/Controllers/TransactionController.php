<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\AssetPriceUpdated;

class TransactionController extends Controller
{
    /**
     * Exibe uma lista de transações do usuário autenticado
     *
     * @return void
     */
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->get();

        $transactions->each(function ($transaction) {
            if ($transaction->asset_type === 'stock') {
                $asset = Stock::find($transaction->asset_id);
                $transaction->asset_name = $asset ? $asset->name : 'Unknown';
            } elseif ($transaction->asset_type === 'fund') {
                $asset = Fund::find($transaction->asset_id);
                $transaction->asset_name = $asset ? $asset->name : 'Unknown';
            } else {
                $transaction->asset_name = 'Unknown';
            }
        });

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Exibe o formulário para criar uma nova transação
     *
     * @return void
     */
    public function create()
    {
    $stocks = Stock::all();
    $funds = Fund::all();

    return view('transactions.create', compact('stocks', 'funds'));
    }

    /**
     * Armazena uma nova transação no banco de dados
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'asset_type' => 'required|string',
            'asset_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $asset = null;

        if ($request->asset_type === 'stock') {
            $asset = Stock::findOrFail($request->asset_id);
        } else if ($request->asset_type === 'fund') {
            $asset = Fund::findOrFail($request->asset_id);
        }

        if ($request->type === 'buy') {
            $asset->price += $request->quantity * 0.01; // Increment price by 1 cent per unit bought
        } else if ($request->type === 'sell') {
            $asset->price -= $request->quantity * 0.01; // Decrement price by 1 cent per unit sold
        }

        $asset->save();

        // Dispatch event to update prices
        broadcast(new AssetPriceUpdated($asset));

        Transaction::create([
            'type' => $request->type,
            'asset_type' => $request->asset_type,
            'asset_id' => $request->asset_id,
            'quantity' => $request->quantity,
            'price' => $asset->price,
            'user_id' => Auth::id(), // Set the user_id to the currently authenticated user
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction completed successfully.');
    }

    /**
     * Realiza a compra de uma ação ou fundo
     *
     * @param Request $request
     * @return void
     */
    public function buy(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'fund_id' => 'required|exists:funds,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $userId = Auth::id();
        $stock = $request->input('stock_id') ? Stock::find($request->input('stock_id')):null;
        $fund = $request->input('fund_id') ? Fund::find($request->input('fund_id')) : null;
        $quantity = $request->input('quantity');

        if ($stock) {
            if ($stock->available_quantity < $quantity) {
                return redirect()->back()->with('error', 'Insufficient quantity');
            }

            $stock->available_quantity -= $quantity;
            $stock->save();

            Transaction::create([
                'user_id' => $userId,
                'stock_id' => $stock->id,
                'fund_id' => $fund->id,
                'quantity' => $quantity,
                'transaction_type' => 'buy',
            ]);
        }

        if ($fund) {
            if ($fund->available_quantity < $quantity) {
                return redirect()->back()->withErrors(['quantity' => 'quantidade disponivel insuficiente']);
        }

        $fund->available_quantity -= $quantity;
        $fund->save();

        Transaction::create([
            'user_id' => $userId,
            'fund_id' => $fund->id,
            'quantity' => $quantity,
            'transaction_type' => 'buy',
        ]);
       }

       return redirect()->route('transactions.index')->with('success', 'Transaction completed successfully.');
    }

    /**
     * Realiza a venda de uma ação ou fundo
     *
     * @param Request $request
     * @return void
     */
    public function sell(Request $request)
    {
        $request->validate([
            'stock_id' => 'nullable|exists:stocks,id',
            'fund_id' => 'nullable|exists:funds,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $stock = $request->input('stock_id') ? Stock::find($request->input('stock_id')):null;
        $fund = $request->input('fund_id') ? Fund::find($request->input('fund_id')):null;
        $quantity = $request->input('quantity');

        if ($stock) {
            $transactionCount = Transaction::where('user_id', $userId)
            ->where('stock_id', $stock->id)
            ->where('type', 'buy')
            ->sum('quantity');

            if ($transactionCount < $quantity) {
                return redirect()->back()->withErrors(['quantity' => 'quantidade insuficiente']);
            }

            $stock->available_quantity += $quantity;
            $stock->save();

            Transaction::create([
                'user_id' => $userId,
                'stock_id' => $stock->id,
                'quantity' => $quantity,
                'type' => 'sell',
            ]);
        }

        if ($fund) {
            $transactionCount = Transaction::where('user_id', $userId)
            ->where('fund_id', $fund->id)
            ->where('type', 'buy')
            ->sum('quantity');

            if ($transactionCount < $quantity) {
                return redirect()->back()->withErrors(['quantity' => 'quantidade insuficiente']);
            }

            $fund->available_quantity += $quantity;
            $fund->save();

            Transaction::create([
                'user_id' => $userId,
                'fund' => $fund->id,
                'quantity' => $quantity,
                'type' => 'sell',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'venda realizada com sucesso');
    }
}
