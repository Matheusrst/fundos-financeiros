<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Stock') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('stocks.update', $stock) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $stock->name) }}" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="priceHistories" class="block text-gray-700">Price Histories</label>
                            <div id="priceHistories">
                                @foreach ($priceHistories as $index => $history)
                                    <div class="price-history mb-4 p-4 border rounded">
                                        <div class="flex items-center mb-2">
                                            <label for="date_{{ $index }}" class="block text-gray-600 mr-2">Date</label>
                                            <input type="date" name="priceHistories[{{ $index }}][date]" id="date_{{ $index }}" value="{{ old('priceHistories.' . $index . '.date', $history->date) }}" class="block w-full" required>
                                        </div>
                                        <div class="flex items-center">
                                            <label for="price_{{ $index }}" class="block text-gray-600 mr-2">Price</label>
                                            <input type="number" step="0.01" name="priceHistories[{{ $index }}][price]" id="price_{{ $index }}" value="{{ old('priceHistories.' . $index . '.price', $history->price) }}" class="block w-full" required>
                                        </div>
                                        <button type="button" class="remove-history mt-2 text-red-500" data-index="{{ $index }}">Remove</button>
                                    </div>
                                @endforeach
                                <button type="button" id="add-price-history" class="bg-blue-500 text-white px-4 py-2 rounded">Add Price History</button>
                            </div>
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceHistoriesContainer = document.getElementById('priceHistories');
            const addButton = document.getElementById('add-price-history');

            let index = {{ count($priceHistories) }};

            addButton.addEventListener('click', function() {
                const newHistoryDiv = document.createElement('div');
                newHistoryDiv.classList.add('price-history', 'mb-4', 'p-4', 'border', 'rounded');
                newHistoryDiv.innerHTML = `
                    <div class="flex items-center mb-2">
                        <label for="date_${index}" class="block text-gray-600 mr-2">Date</label>
                        <input type="date" name="priceHistories[${index}][date]" id="date_${index}" class="block w-full" required>
                    </div>
                    <div class="flex items-center">
                        <label for="price_${index}" class="block text-gray-600 mr-2">Price</label>
                        <input type="number" step="0.01" name="priceHistories[${index}][price]" id="price_${index}" class="block w-full" required>
                    </div>
                    <button type="button" class="remove-history mt-2 text-red-500" data-index="${index}">Remove</button>
                `;
                priceHistoriesContainer.appendChild(newHistoryDiv);
                index++;
            });

            priceHistoriesContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-history')) {
                    const indexToRemove = event.target.dataset.index;
                    const historyToRemove = document.querySelector(`#date_${indexToRemove}`).parentElement.parentElement;
                    historyToRemove.remove();
                }
            });
        });
    </script>
</x-app-layout>
