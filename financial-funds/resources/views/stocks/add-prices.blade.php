<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Prices for Stock') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Formulário para adicionar preços para uma ação -->
                    <form action="{{ route('stocks.add-prices', ['stock' => $stock->id]) }}" method="POST">
                        @csrf

                        <!-- Seção para inserir os preços -->
                        <div class="mb-4">
                            <label for="prices" class="block text-gray-700">Prices</label>
                            <div id="prices">
                                <!-- Entrada de preço inicial -->
                                <div class="price-entry mb-4 p-4 border rounded">
                                    <div class="flex items-center mb-2">
                                        <label for="price_0" class="block text-gray-600 mr-2">Price</label>
                                        <input type="number" step="0.01" name="prices[0][price]" id="price_0" class="block w-full" required>
                                    </div>
                                    <div class="flex items-center">
                                        <label for="date_0" class="block text-gray-600 mr-2">Date</label>
                                        <input type="date" name="prices[0][date]" id="date_0" class="block w-full" required>
                                    </div>
                                    <!-- Botão para remover a entrada de preço -->
                                    <button type="button" class="remove-price-entry mt-2 text-red-500" data-index="0">Remove</button>
                                </div>
                            </div>
                            <!-- Botão para adicionar novas entradas de preço -->
                            <button type="button" id="add-price-entry" class="bg-blue-500 text-white px-4 py-2 rounded">Add Price Entry</button>
                        </div>

                        <!-- Botão para submeter o formulário -->
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Prices</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pricesContainer = document.getElementById('prices');
            const addButton = document.getElementById('add-price-entry');

            let index = 1; // Índice para novas entradas de preço

            // Adiciona uma nova entrada de preço quando o botão é clicado
            addButton.addEventListener('click', function() {
                const newPriceEntry = document.createElement('div');
                newPriceEntry.classList.add('price-entry', 'mb-4', 'p-4', 'border', 'rounded');
                newPriceEntry.innerHTML = `
                    <div class="flex items-center mb-2">
                        <label for="price_${index}" class="block text-gray-600 mr-2">Price</label>
                        <input type="number" step="0.01" name="prices[${index}][price]" id="price_${index}" class="block w-full" required>
                    </div>
                    <div class="flex items-center">
                        <label for="date_${index}" class="block text-gray-600 mr-2">Date</label>
                        <input type="date" name="prices[${index}][date]" id="date_${index}" class="block w-full" required>
                    </div>
                    <!-- Botão para remover a nova entrada de preço -->
                    <button type="button" class="remove-price-entry mt-2 text-red-500" data-index="${index}">Remove</button>
                `;
                pricesContainer.appendChild(newPriceEntry);
                index++; // Incrementa o índice para a próxima entrada
            });

            // Remove uma entrada de preço quando o botão correspondente é clicado
            pricesContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-price-entry')) {
                    const indexToRemove = event.target.dataset.index;
                    const entryToRemove = document.querySelector(`#price_${indexToRemove}`).parentElement.parentElement;
                    entryToRemove.remove();
                }
            });
        });
    </script>
</x-app-layout>
