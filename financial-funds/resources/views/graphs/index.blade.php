<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Graphs Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Seção para Stocks -->
                    <h3 class="text-lg font-medium mb-4">Stocks</h3>
                    <ul>
                        <!-- Itera sobre cada ação e exibe um link para o gráfico correspondente -->
                        @foreach ($stocks as $stock)
                            <li class="mb-2">
                                <!-- Link para visualizar o gráfico da ação -->
                                <a href="{{ route('graphs.show', ['id' => $stock->id, 'type' => 'stock']) }}" class="text-blue-600 hover:underline">
                                    {{ $stock->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Seção para Funds -->
                    <h3 class="text-lg font-medium mt-8 mb-4">Funds</h3>
                    <ul>
                        <!-- Itera sobre cada fundo e exibe um link para o gráfico correspondente -->
                        @foreach ($funds as $fund)
                            <li class="mb-2">
                                <!-- Link para visualizar o gráfico do fundo -->
                                <a href="{{ route('graphs.show', ['id' => $fund->id, 'type' => 'fund']) }}" class="text-blue-600 hover:underline">
                                    {{ $fund->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
