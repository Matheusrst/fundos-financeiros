<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Balance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Mensagem de sucesso -->
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Mensagem de erro -->
                    @if (session('error'))
                        <div class="mb-4 font-medium text-sm text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Formulário para adicionar saldo -->
                    <form method="POST" action="{{ route('wallet.addBalance') }}">
                        @csrf
                        <div>
                            <!-- Rótulo e campo de entrada para o valor -->
                            <x-label for="amount" :value="__('Amount')" />
                            <x-input id="amount" class="block mt-1 w-full" type="number" name="amount" step="0.01" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <!-- Botão para enviar o formulário -->
                            <x-button class="ml-4">
                                {{ __('Add Balance') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
