<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Fund;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::paginate(10);
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $stock = Stock::create($validatedData);

        return redirect()->route('stocks.show', $stock);
    }

    public function show($id)
    {
    $stock = Stock::findOrFail($id);

    // Obtenha os dados históricos de preços, se houver
    $priceHistories = $stock->priceHistories()->orderBy('date')->get();

    // Inicialize os labels e preços com valores padrão
    $labels = [];
    $prices = [];

    // Se houver históricos de preços, formate os dados
    if ($priceHistories->isNotEmpty()) {
        $labels = $priceHistories->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d/m/Y');
        });
        $prices = $priceHistories->pluck('price');
    } else {
        // Se não houver históricos de preços, use o preço atual do stock para o gráfico
        $labels = ['Current Price'];
        $prices = [$stock->price];
    }

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

    public function addPricesForm($stockId)
    {
        $stock = Stock::findOrFail($stockId);

        return view('stocks.add-prices', compact('stock'));
    }

    public function addPrices(Request $request, $stockId)
    {
    $request->validate([
        'prices' => 'required|array',
        'prices.*.price' => 'required|numeric',
        'prices.*.date' => 'required|date',
    ]);

    $stock = Stock::findOrFail($stockId);

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

    public function storePrices(Request $request, Stock $stock)
    {
        foreach ($request->input('prices', []) as $priceData) {
            $stock->priceHistories()->create($priceData);
        }

        return redirect()->route('stocks.show', $stock);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index');
    }
}
