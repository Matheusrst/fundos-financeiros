<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'price' => 'required']);
        Stock::create($request->all());
        return redirect()->route('stocks.index');
    }

    public function show($id)
{
    $stock = Stock::findOrFail($id);
    $priceHistories = PriceHistory::where('stock_id', $id)->orderBy('date')->get();
    $labels = $priceHistories->pluck('date')->map(fn($date) => $date->format('Y-m-d'));
    $prices = $priceHistories->pluck('price');

    return view('stocks.show', compact('stock', 'labels', 'prices'));
}

    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate(['name' => 'required', 'price' => 'required']);
        $stock->update($request->all());
        return redirect()->route('stocks.index');
    }

    public function addPrices(Request $request)
    {
        $request->validate9([
            'stock_id' => 'required|exists:stocks,id',
            'prices' => 'required|array',
            'prices.*.date' => 'required|date',
            'prices.*.price' => 'required|numeric',
        ]);

        foreach ($request->prices as $priceData) {
            PriceHistory::create([
                'stock_id' => $request->stock_id,
                'date' => $priceData['date'],
                'price' => $priceData['price'],
            ]);
        }

        return redirect()->route('stocks.index')->with('success', 'Prices added successfully');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index');
    }
}
