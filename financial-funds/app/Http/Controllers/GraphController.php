<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Fund;

class GraphController extends Controller
{
    /**
     * Exibe a página inicial dos gráficos com dados de ações e fundos
     *
     * @return void
     */
    public function index()
    {
        $stocks = Stock::with('pricehistories')->get();
        $funds = Fund::with('pricehistories')->get();

        return view('graphs.index', [
            'stocks' => $stocks,
            'funds' => $funds
        ]);
    }

    /**
     * Exibe o gráfico para uma ação ou fundo específico
     *
     * @param [type] $type
     * @param [type] $id
     * @return void
     */
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
