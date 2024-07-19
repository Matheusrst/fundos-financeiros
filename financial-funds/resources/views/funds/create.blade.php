<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Fund') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Formulário para criar um novo fundo -->
                    <form method="POST" action="{{ route('funds.store') }}">
                        @csrf
                        <!-- Campo para o nome do fundo -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Fund Name</label>
                            <input type="text" id="name" name="name" class="form-input mt-1 block w-full" required>
                        </div>

                        <!-- Campo para o preço do fundo -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <input type="number" id="price" name="price" step="0.01" class="form-input mt-1 block w-full" required>
                        </div>

                        <!-- Botão para submeter o formulário -->
                        <div class="flex items-center justify-end">
                            <x-button>Submit</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
