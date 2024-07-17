<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fund Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold">{{ $fund->name }}</h3>

                    <!-- Price History Table -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fund->priceHistories as $priceHistory)
                                <tr>
                                    <td>{{ $priceHistory->date }}</td>
                                    <td>{{ $priceHistory->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Chart -->
                    <div class="mt-4">
                        <canvas id="fundChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('fundChart').getContext('2d');
        var fundChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($fund->priceHistories->pluck('date')),
                datasets: [{
                    label: 'Fund Prices',
                    data: @json($fund->priceHistories->pluck('price')),
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Price'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
