<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Stock') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Formulário para criar uma nova ação -->
                    <form action="{{ route('stocks.store') }}" method="POST">
                        @csrf <!-- Token CSRF para proteger contra ataques CSRF -->

                        <!-- Entrada para o nome da ação -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full" required>
                        </div>

                        <!-- Entrada para o preço da ação -->
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700">Price</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="mt-1 block w-full" required>
                        </div>

                        <!-- Botão para submeter o formulário e criar a nova ação -->
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
