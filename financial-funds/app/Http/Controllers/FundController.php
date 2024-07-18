<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fund;
use App\Models\PriceHistory;
use Carbon\Carbon;

class FundController extends Controller
{
    public function index()
    {
        $funds = Fund::all();
        return view('funds.index', compact('funds'));
    }

    public function create()
    {
        return view('funds.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'price' => 'required']);
        Fund::create($request->all());
        return redirect()->route('funds.index');
    }

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

    public function createPrices($id)
    {
        $fund = Fund::findOrFail($id);
        return view('funds.create', compact('fund'));
    }

    public function addPricesForm($fund)
    {
    $fund = Fund::findOrFail($fund);
    return view('funds.add-prices-form', compact('fund'));
    }

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

    public function storePrices(Request $request, $fund)
    {
    $request->validate([
        'date' => 'required|date',
        'price' => 'required|numeric|min:0',
    ]);

    $fund = Fund::findOrFail($fund);

    $fund->priceHistories()->create([
        'date' => $request->date,
        'price' => $request->price,
    ]);

    return redirect()->route('funds.show', $fund)->with('success', 'Price added successfully.');
    }

    public function destroy(Fund $fund)
    {
        $fund->delete();
        return redirect()->route('funds.index');
    }
}
