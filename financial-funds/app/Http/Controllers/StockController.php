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
        /**
         * Exibe uma lista paginada de todas as ações
         */
        $stocks = Stock::paginate(10);
        return view('stocks.index', compact('stocks'));
    }

    /**
     * Exibe o formulário para criar uma nova ação
     *
     * @return void
     */
    public function create()
    {
        return view('stocks.create');
    }

    /**
     * Armazena uma nova ação no banco de dados
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $stock = Stock::create($validatedData);

        return redirect()->route('stocks.show', $stock);
    }

    /**
     * Exibe uma ação específica com seu histórico de preços
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
    $stock = Stock::findOrFail($id);

    $priceHistories = $stock->priceHistories()->orderBy('date')->get();

    $labels = [];
    $prices = [];

    if ($priceHistories->isNotEmpty()) {
        $labels = $priceHistories->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d/m/Y');
        });
        $prices = $priceHistories->pluck('price');
    } else {
        $labels = ['Current Price'];
        $prices = [$stock->price];
    }

    return view('stocks.show', compact('stock', 'labels', 'prices'));
    }

    /**
     * Exibe o formulário para editar uma ação existente
     *
     * @param [type] $id
     * @return void
     */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        $priceHistories = $stock->priceHistories;

        return view('stocks.edit', compact('stock', 'priceHistories'));
    }

    /**
     * Atualiza uma ação existente no banco de dados
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
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

    /**
     * Exibe o formulário para adicionar preços a uma ação existente
     *
     * @param [type] $stockId
     * @return void
     */
    public function addPricesForm($stockId)
    {
        $stock = Stock::findOrFail($stockId);

        return view('stocks.add-prices', compact('stock'));
    }

    /**
     * Armazena novos preços para uma ação específica
     *
     * @param Request $request
     * @param [type] $stockId
     * @return void
     */
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

    /**
     * Armazena novos preços para uma ação específica (função alternativa)
     *
     * @param Request $request
     * @param Stock $stock
     * @return void
     */
    public function storePrices(Request $request, Stock $stock)
    {
        foreach ($request->input('prices', []) as $priceData) {
            $stock->priceHistories()->create($priceData);
        }

        return redirect()->route('stocks.show', $stock);
    }

    /**
     * Remove uma ação do banco de dados
     *
     * @param Stock $stock
     * @return void
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index');
    }
}
