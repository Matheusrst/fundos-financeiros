<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            $wallet = $user->wallet()->create(['balance' => 0]);
        }

        return view('wallet.index', compact('wallet'));
    }

    public function showAddBalanceForm()
    {
        return view('wallet.add');
    }

    public function addBalance(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        if ($wallet) {
            $wallet->balance += $request->amount;
            $wallet->save();
            
            return redirect()->route('wallet.index')->with('success', 'Balance added successfully.');
        }

        return redirect()->route('wallet.index')->with('error', 'wallet not found.');
    }
}
