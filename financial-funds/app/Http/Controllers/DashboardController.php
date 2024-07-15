<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Supondo que você tenha modelos Stock e Fund para recuperar dados
        $stocks = \App\Models\Stock::all();
        $funds = \App\Models\Fund::all();

        // Processar dados para os gráficos
        $stockLabels = $stocks->pluck('name');
        $stockData = $stocks->pluck('price');
        $fundLabels = $funds->pluck('name');
        $fundData = $funds->pluck('price');

        return view('dashboard', compact('stockLabels', 'stockData', 'fundLabels', 'fundData'));
    }
}