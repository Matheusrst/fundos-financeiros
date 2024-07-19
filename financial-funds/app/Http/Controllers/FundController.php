<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fund;
use App\Models\PriceHistory;
use Carbon\Carbon;

class FundController extends Controller
{
    /**
     * Exibe uma lista de todos os fundoss
     *
     * @return void
     */
    public function index()
    {
        $funds = Fund::all();
        return view('funds.index', compact('funds'));
    }

    /**
     * Exibe o formulário para criar um novo fundo
     *
     * @return void
     */
    public function create()
    {
        return view('funds.create');
    }

    /**
     * Armazena um novo fundo no banco de dados
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

        $fund = Fund::create($validatedData);

        return redirect()->route('funds.show', $fund);
    }

    /**
     * Exibe um fundo específico com seu histórico de preços
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $fund = Fund::findOrFail($id);
        $priceHistories = $fund->priceHistories()->orderBy('date')->get();

        $initialPrice = $priceHistories->first()->price ?? 0;

        $labels = $priceHistories->map(function($history) {
          return \Carbon\Carbon::parse($history->date)->format('Y-m-d\TH:i:s\Z');
        })->toArray();

        $prices = $priceHistories->map(function($history) {
            return $history->price;
        })->toArray();

        return view('funds.show', compact('fund', 'labels', 'prices', 'initialPrice'));
    }

    /**
     * Exibe o formulário para editar um fundo existente
     *
     * @param Fund $fund
     * @return void
     */
    public function edit(Fund $fund)
    {
        $priceHistories = $fund->priceHistories->map(function($history) {
            $history->date = \Carbon\Carbon::parse($history->date)->format('Y-m-d');
            return $history;
        });

        return view('funds.edit', [
            'fund' => $fund,
            'priceHistories' => $priceHistories
        ]);
    }

    /**
     * Atualiza um fundo existente no banco de dados
     *
     * @param Request $request
     * @param Fund $fund
     * @return void
     */
    public function update(Request $request, Fund $fund)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'priceHistories.*.date' => 'required|date',
            'priceHistories.*.price' => 'required|numeric',
        ]);

        $fund->update([
            'name' => $request->input('name'),
        ]);

        foreach ($request->input('priceHistories') as $priceHistory) {
            $fund->priceHistories()->updateOrCreate(
                ['date' => $priceHistory['date']],
                ['price' => $priceHistory['price']]
            );
        }

        return redirect()->route('funds.index')->with('success', 'Fund updated successfully.');
    }

    /**
     * Exibe o formulário para adicionar preços a um fundo existente
     *
     * @param [type] $id
     * @return void
     */
    public function createPrices($id)
    {
        $fund = Fund::findOrFail($id);
        return view('funds.create', compact('fund'));
    }

    /**
     * Exibe o formulário para adicionar preços a um fundo específico
     *
     * @param [type] $fund
     * @return void
     */
    public function addPricesForm($fund)
    {
    $fund = Fund::findOrFail($fund);
    return view('funds.add-prices-form', compact('fund'));
    }

    /**
     * Armazena novos preços para um fundo específico
     *
     * @param Request $request
     * @return void
     */
    public function addPrices(Request $request)
    {
        $request->validate([
            'fund_id' => 'required|exists:funds,id',
            'prices' => 'required|array',
            'prices.*.date' => 'required|date',
            'prices.*.price' => 'required|numeric',
        ]);

        foreach ($request->prices as $priceData) {
            PriceHistory::create([
                'fund_id' => $request->fund_id,
                'date' => $priceData['date'],
                'price' => $priceData['price'],
            ]);
        }

        return redirect()->route('funds.show', ['id' => $request->fund_id])
                         ->with('success', 'Prices added successfully.');
    }

    /**
     * Armazena novos preços para um fundo específico (função alternativa)
     *
     * @param Request $request
     * @param Fund $fund
     * @return void
     */
    public function storePrices(Request $request, Fund $fund)
    {
        foreach ($request->input('prices', []) as $priceData) {
            $fund->priceHistories()->create($priceData);
        }

        return redirect()->route('funds.show', $fund);
    }

    /**
     * Remove um fundo do banco de dados
     *
     * @param Fund $fund
     * @return void
     */
    public function destroy(Fund $fund)
    {
        $fund->delete();
        return redirect()->route('funds.index');
    }
}
