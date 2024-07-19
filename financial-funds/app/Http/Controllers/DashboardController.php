<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Exibe o painel com dados de ações e fundos
     *
     * @return void
     */
    public function index()
    {
        $stocks = \App\Models\Stock::all();
        $funds = \App\Models\Fund::all();

        $stockLabels = $stocks->pluck('name');
        $stockData = $stocks->pluck('price');
        $fundLabels = $funds->pluck('name');
        $fundData = $funds->pluck('price');

        return view('dashboard', compact('stockLabels', 'stockData', 'fundLabels', 'fundData'));
    }
}