<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Prices for Fund') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('funds.add-prices') }}">
                        @csrf
                        <input type="hidden" name="fund_id" value="{{ $fund->id }}">

                        <div id="prices-container">
                            <div class="price-item">
                                <label for="date">Date:</label>
                                <input type="date" name="prices[0][date]" required>

                                <label for="price">Price:</label>
                                <input type="text" name="prices[0][price]" required>
                            </div>
                        </div>

                        <button type="button" id="add-price" class="mt-2 bg-blue-500 text-white px-4 py-2">Add More Prices</button>
                        <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-price').addEventListener('click', function () {
            var container = document.getElementById('prices-container');
            var index = container.getElementsByClassName('price-item').length;

            var newItem = document.createElement('div');
            newItem.classList.add('price-item');
            newItem.innerHTML = `
                <label for="date">Date:</label>
                <input type="date" name="prices[${index}][date]" required>

                <label for="price">Price:</label>
                <input type="text" name="prices[${index}][price]" required>
            `;
            container.appendChild(newItem);
        });
    </script>
</x-app-layout>
