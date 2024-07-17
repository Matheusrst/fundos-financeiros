<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Fund;

class GraphController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        $funds = Fund::all();
        
        return view('graphs.index', compact('stocks', 'funds'));
    }

    public function show($type, $id)
    {
        if($type === 'stock'){
            $asset = Stock::findOrFail($id);
        } elseif ($type === 'fund'){
            $asset = Fund::findOrFail($id);
        } else {
            abort(404);
        }

        $labels = range(1, 30);
        $prices = array_fill(0, 30, $asset->price);

        return view('graphs.show', compact('asset', 'labels', 'prices'));
    }
}
