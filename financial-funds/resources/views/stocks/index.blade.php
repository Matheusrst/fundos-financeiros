<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stocks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Seção superior com título e botão para adicionar uma nova ação -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">All Stocks</h3>
                        <a href="{{ route('stocks.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Add New Stock
                        </a>
                    </div>
                    
                    <!-- Tabela com informações das ações -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Itera sobre todas as ações e as exibe em linhas -->
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stock->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">${{ $stock->price }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <!-- Links para visualizar, editar, adicionar preços ou excluir uma ação -->
                                        <a href="{{ route('stocks.show', $stock->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        <a href="{{ route('stocks.edit', $stock->id) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">Edit</a>
                                        <a href="{{ route('stocks.add-prices-form', $stock->id) }}" class="text-green-600 hover:text-green-900 ml-4">Add Prices</a>
                                        <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" class="inline">
                                            @csrf <!-- Token CSRF para proteção contra ataques CSRF -->
                                            @method('DELETE') <!-- Define o método HTTP para exclusão (DELETE) -->
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Paginação dos resultados -->
                    <div class="mt-4">
                        {{ $stocks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
