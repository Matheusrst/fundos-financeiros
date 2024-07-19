<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Prices for Fund') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Formulário para adicionar preços ao fundo -->
                    <form method="POST" action="{{ route('funds.add-prices') }}">
                        @csrf
                        <!-- Campo oculto para o ID do fundo -->
                        <input type="hidden" name="fund_id" value="{{ $fund->id }}">

                        <!-- Container para armazenar entradas de preços -->
                        <div id="prices-container">
                            <div class="price-item">
                                <!-- Entrada inicial para data e preço -->
                                <label for="date">Date:</label>
                                <input type="date" name="prices[0][date]" required>

                                <label for="price">Price:</label>
                                <input type="text" name="prices[0][price]" required>
                            </div>
                        </div>

                        <!-- Botão para adicionar mais entradas de preço -->
                        <button type="button" id="add-price" class="mt-2 bg-blue-500 text-white px-4 py-2">Add More Prices</button>
                        <!-- Botão para submeter o formulário -->
                        <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Adiciona um manipulador de evento para o botão "Add More Prices"
        document.getElementById('add-price').addEventListener('click', function () {
            var container = document.getElementById('prices-container');
            // Obtém o número atual de entradas de preço
            var index = container.getElementsByClassName('price-item').length;

            // Cria uma nova entrada de preço
            var newItem = document.createElement('div');
            newItem.classList.add('price-item');
            newItem.innerHTML = `
                <label for="date">Date:</label>
                <input type="date" name="prices[${index}][date]" required>

                <label for="price">Price:</label>
                <input type="text" name="prices[${index}][price]" required>
            `;
            // Adiciona a nova entrada ao container
            container.appendChild(newItem);
        });
    </script>
</x-app-layout>
