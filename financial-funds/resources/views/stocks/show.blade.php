<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ $stock->name }}</h3>

                    <!-- Price History Table -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stock->priceHistories as $priceHistory)
                                <tr>
                                    <td>{{ $priceHistory->date }}</td>
                                    <td>{{ $priceHistory->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Exibir gráfico -->
                    <div>
                        <canvas id="stockChart" width="400" height="200"></canvas>
                    </div>

                    @if ($labels && $prices)
                        @if (count($labels) > 0 && count($prices) > 0)
                            <script>
                                var ctx = document.getElementById('stockChart').getContext('2d');
                                var stockChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: {!! json_encode($labels) !!},
                                        datasets: [{
                                            label: 'Price History',
                                            data: {!! json_encode($prices) !!},
                                            borderWidth: 1,
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: false
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                        @else
                            <p>No price history available.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
