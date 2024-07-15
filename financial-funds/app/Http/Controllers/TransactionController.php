<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['stock', 'fund'])->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
{
    $stocks = Stock::all();
    $funds = Fund::all();

    return view('transactions.create', compact('stocks', 'funds'));
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'type' => 'required|in:buy,sell',
        'asset_type' => 'required|in:stock,fund',
        'asset_id' => 'required|integer',
        'quantity' => 'required|integer|min:1',
    ]);

    if ($validated['asset_type'] === 'stock') {
        $asset = Stock::find($validated['asset_id']);
    } else {
        $asset = Fund::find($validated['asset_id']);
    }

    if (!$asset) {
        return redirect()->back()->withErrors(['asset_id' => 'Invalid asset selected.']);
    }

    $transaction = new Transaction();
    $transaction->type = $validated['type'];
    $transaction->quantity = $validated['quantity'];
    $transaction->user_id = auth()->id();

    if ($validated['asset_type'] === 'stock') {
        $transaction->stock_id = $asset->id;
    } else {
        $transaction->fund_id = $asset->id;
    }

    $transaction->save();

    return redirect()->route('transactions.index')->with('success', 'Transaction completed successfully.');
}

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
