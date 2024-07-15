<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fund;

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

    public function edit (Fund $fund)
    {
        return view('funds.edit', compact('fund'));
    }

    public function update(request $request, Fund $fund)
    {
        $request->validate(['name' => 'required', 'price' => 'required']);
        $fund->update($request->all());
        return redirect()->route('funds.index');
    }

    public function destroy(Fund $fund)
    {
        $fund->delete();
        return redirect()->route('funds.index');
    }
}
