<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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
                    <canvas id="stockChart"></canvas>
                    <canvas id="fundChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        var stockCtx = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(stockCtx, {
            type: 'line',
            data: {
                labels: @json($stockLabels),
                datasets: [{
                    label: 'Stock Prices',
                    data: @json($stockData),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var fundCtx = document.getElementById('fundChart').getContext('2d');
        var fundChart = new Chart(fundCtx, {
            type: 'line',
            data: {
                labels: @json($fundLabels),
                datasets: [{
                    label: 'Fund Prices',
                    data: @json($fundData),
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
