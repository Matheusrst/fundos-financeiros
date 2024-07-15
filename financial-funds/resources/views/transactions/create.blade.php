<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('transactions.buy') }}" method="POST">
                        @csrf
                        <div>
                            <label for="stock_id">Stock</label>
                            <select name="stock_id" id="stock_id">
                                <option value="">Select Stock</option>
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="fund_id">Fund</label>
                            <select name="fund_id" id="fund_id">
                                <option value="">Select Fund</option>
                                @foreach($funds as $fund)
                                    <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" required>
                        </div>
                        <button type="submit">Buy</button>
                    </form>

                    <form action="{{ route('transactions.sell') }}" method="POST">
                        @csrf
                        <div>
                            <label for="stock_id">Stock</label>
                            <select name="stock_id" id="stock_id">
                                <option value="">Select Stock</option>
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="fund_id">Fund</label>
                            <select name="fund_id" id="fund_id">
                                <option value="">Select Fund</option>
                                @foreach($funds as $fund)
                                    <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" required>
                        </div>
                        <button type="submit">Sell</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
