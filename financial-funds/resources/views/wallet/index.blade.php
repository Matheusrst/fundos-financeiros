<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wallet') }}
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <th>|</th>
            <a href="{{ route('stocks.index') }}">Stocks</a>
            <th>|</th>
            <a href="{{ route('funds.index') }}">Funds</a>
            <th>|</th>
            <a href="{{ route('transactions.index') }}">Transaction History</a>
            <th>|</th>
            <a href="{{ route('transactions.create') }}">Manage Transactions</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($wallet)
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ __('Current Balance') }}: ${{ number_format($wallet->balance, 2) }}
                        </h3>
                    @else
                        <p>{{ __('No wallet found.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>