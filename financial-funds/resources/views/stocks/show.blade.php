<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Nome da ação -->
                    <h3 class="text-lg font-semibold mb-4">{{ $stock->name }}</h3>

                    <!-- Tabela de histórico de preços -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Itera sobre o histórico de preços da ação -->
                            @foreach ($stock->priceHistories as $priceHistory)
                                <tr>
                                    <td>{{ $priceHistory->date }}</td>
                                    <td>{{ $priceHistory->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Exibe o gráfico -->
                    <div>
                        <canvas id="stockChart" width="400" height="200"></canvas>
                    </div>

                    @if ($labels && $prices)
                        <!-- Verifica se há rótulos e preços disponíveis -->
                        @if (count($labels) > 0 && count($prices) > 0)
                            <script>
                                // Inicializa o gráfico com Chart.js
                                var ctx = document.getElementById('stockChart').getContext('2d');
                                var stockChart = new Chart(ctx, {
                                    type: 'line', // Tipo de gráfico: linha
                                    data: {
                                        labels: {!! json_encode($labels) !!}, // Rótulos para o eixo X
                                        datasets: [{
                                            label: 'Price History',
                                            data: {!! json_encode($prices) !!}, // Dados para o eixo Y
                                            borderWidth: 1, // Largura da borda da linha
                                            borderColor: 'rgba(75, 192, 192, 1)', // Cor da borda da linha
                                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Cor de fundo da linha
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: false // Começar o eixo Y em zero
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                        @else
                            <p>No price history available.</p> <!-- Mensagem caso não haja dados -->
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
