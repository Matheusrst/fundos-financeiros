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

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        $priceHistories = $stock->priceHistories;

        return view('stocks.edit', compact('stock', 'priceHistories'));
    }


    public function update(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'priceHistories' => 'required|array',
        'priceHistories.*.price' => 'required|numeric',
        'priceHistories.*.date' => 'required|date',
    ]);

    $stock = Stock::findOrFail($id);
    $stock->update(['name' => $request->name]);

    $stock->priceHistories()->delete();

    foreach ($request->priceHistories as $priceData) {
        PriceHistory::create([
            'priceable_id' => $stock->id,
            'priceable_type' => Stock::class,
            'price' => $priceData['price'],
            'date' => $priceData['date'],
        ]);
    }

    return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
    }

    public function addPrices(Request $request, $id)
    {
        $request->validate([
            'prices' => 'required|array',
            'prices.*.price' => 'required|numeric',
            'prices.*.date' => 'required|date',
        ]);

        $stock = Stock::findOrFail($id);

        foreach ($request->prices as $priceData) {
            PriceHistory::create([
                'priceable_id' => $stock->id,
                'priceable_type' => Stock::class,
                'price' => $priceData['price'],
                'date' => $priceData['date'],
            ]);
        }

        return redirect()->route('stocks.show', $stock->id)->with('success', 'Prices added successfully.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index');
    }
}
