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

    <!-- Ensure Chart.js is loaded -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Ensure Echo is loaded -->
    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stockCtx = document.getElementById('stockChart').getContext('2d');
            const fundCtx = document.getElementById('fundChart').getContext('2d');

            const stockChart = new Chart(stockCtx, {
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

            const fundChart = new Chart(fundCtx, {
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

            window.Echo.channel('asset-prices')
                .listen('AssetPriceUpdated', (e) => {
                    const assetType = e.asset_type;
                    const price = e.price;
                    const timestamp = new Date().toLocaleTimeString();

                    if (assetType === 'stock') {
                        stockChart.data.labels.push(timestamp);
                        stockChart.data.datasets[0].data.push(price);
                        stockChart.update();
                    } else if (assetType === 'fund') {
                        fundChart.data.labels.push(timestamp);
                        fundChart.data.datasets[0].data.push(price);
                        fundChart.update();
                    }
                });
        });
    </script>
</x-app-layout>
