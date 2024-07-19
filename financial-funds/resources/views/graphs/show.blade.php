<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Graph Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Nome do ativo, seja ação ou fundo -->
                    <h3 class="text-lg font-semibold">{{ $asset->name }} </h3>
                    <!-- Canvas onde o gráfico será renderizado -->
                    <canvas id="assetChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusão da biblioteca Chart.js para renderização de gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Inicializa o gráfico quando o DOM está totalmente carregado
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('assetChart').getContext('2d');
            var assetChart = new Chart(ctx, {
                type: 'line', // Tipo de gráfico: linha
                data: {
                    // Dados do gráfico
                    labels: @json($asset->priceHistories->pluck('date')), // Labels do gráfico, extraídos das datas
                    datasets: [{
                        label: '{{ $asset->name }} Prices', // Rótulo da linha do gráfico com o nome do ativo
                        data: @json($asset->priceHistories->pluck('price')), // Dados dos preços para o gráfico
                        borderColor: 'rgba(75, 192, 192, 1)', // Cor da linha do gráfico
                        borderWidth: 1 // Largura da linha
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true, // Exibe o título do eixo X
                                text: 'Date' // Texto do título do eixo X
                            }
                        },
                        y: {
                            title: {
                                display: true, // Exibe o título do eixo Y
                                text: 'Price' // Texto do título do eixo Y
                            },
                            beginAtZero: true // Inicia o eixo Y a partir de zero
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
