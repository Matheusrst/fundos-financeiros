<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fund Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Nome do fundo -->
                    <h3 class="text-lg font-semibold">{{ $fund->name }}</h3>

                    <!-- Tabela de Histórico de Preços -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <!-- Cabeçalhos das colunas da tabela -->
                                <th>Date</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Itera sobre cada histórico de preço e exibe uma linha na tabela -->
                            @foreach ($fund->priceHistories as $priceHistory)
                                <tr>
                                    <td>{{ $priceHistory->date }}</td>
                                    <td>{{ $priceHistory->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Gráfico -->
                    <div class="mt-4">
                        <!-- Canvas para o gráfico -->
                        <canvas id="fundChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inicializa o gráfico quando o DOM está totalmente carregado
        var ctx = document.getElementById('fundChart').getContext('2d');
        var fundChart = new Chart(ctx, {
            type: 'line', // Tipo de gráfico: linha
            data: {
                labels: @json($fund->priceHistories->pluck('date')), // Labels do gráfico, extraídos das datas
                datasets: [{
                    label: 'Fund Prices', // Rótulo da linha do gráfico
                    data: @json($fund->priceHistories->pluck('price')), // Dados dos preços para o gráfico
                    borderColor: 'rgba(153, 102, 255, 1)', // Cor da linha do gráfico
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
    </script>
</x-app-layout>
