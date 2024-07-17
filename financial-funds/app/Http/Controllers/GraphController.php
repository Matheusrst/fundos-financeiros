<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Fund;

class GraphController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('priceHistories')->get();
        $funds = Fund::with('priceHistories')->get();

        return view('graphs.index', [
            'stocks' => $stocks,
            'funds' => $funds
        ]);
    }

    public function show($type, $id)
{
    if ($type === 'stock') {
        $asset = Stock::findOrFail($id);
        $priceHistories = $asset->priceHistories()->orderBy('date')->get();
    } elseif ($type === 'fund') {
        $asset = Fund::findOrFail($id);
        $priceHistories = $asset->priceHistories()->orderBy('date')->get();
    } else {
        abort(404);
    }

    // Obter o preço inicial
    $initialPrice = $priceHistories->first()->price ?? 0;

    // Preparar os dados para o gráfico
    $labels = $priceHistories->map(function($history) {
        return \Carbon\Carbon::parse($history->date)->format('Y-m-d');
    })->toArray();
    
    $prices = $priceHistories->map(function($history) {
        return $history->price;
    })->toArray();

    return view('graphs.show', [
        'asset' => $asset,
        'labels' => $labels,
        'prices' => $prices,
        'initialPrice' => $initialPrice
    ]);
}

}
