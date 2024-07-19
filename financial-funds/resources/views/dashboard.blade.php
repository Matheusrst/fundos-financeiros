<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Áreas para os gráficos -->
                    <canvas id="stockChart"></canvas>
                    <canvas id="fundChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Carregamento do Chart.js para renderização dos gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Carregamento do arquivo JavaScript compilado com Laravel Mix -->
    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Contextos dos gráficos
            const stockCtx = document.getElementById('stockChart').getContext('2d');
            const fundCtx = document.getElementById('fundChart').getContext('2d');

            // Configuração do gráfico de ações
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

            // Configuração do gráfico de fundos
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

            // Configuração para atualização dos gráficos em tempo real com Laravel Echo
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
