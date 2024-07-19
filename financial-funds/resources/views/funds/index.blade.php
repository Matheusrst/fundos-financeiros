<x-app-layout>
    <x-slot name="header">
        <!-- Cabeçalho da página com o título principal -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Funds') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Container principal com espaçamento e largura máxima -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de conteúdo com fundo branco e sombra -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Seção de cabeçalho da tabela com botão para adicionar novos fundos -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">All Funds</h3>
                        <!-- Link para criar um novo fundo -->
                        <a href="{{ route('funds.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Add New Fund
                        </a>
                    </div>
                    
                    <!-- Tabela para exibir todos os fundos -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <!-- Cabeçalhos das colunas da tabela -->
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
                            <!-- Itera sobre cada fundo e exibe uma linha na tabela -->
                            @foreach ($funds as $fund)
                                <tr>
                                    <!-- Coluna para o nome do fundo -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $fund->name }}</div>
                                    </td>
                                    <!-- Coluna para o preço do fundo -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">${{ $fund->price }}</div>
                                    </td>
                                    <!-- Coluna para as ações disponíveis para cada fundo -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <!-- Links para visualizar, editar, adicionar preços e deletar o fundo -->
                                        <a href="{{ route('funds.show', $fund->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        <a href="{{ route('funds.edit', $fund->id) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">Edit</a>
                                        <a href="{{ route('funds.add-prices-form', $fund->id) }}" class="text-green-600 hover:text-green-900 ml-4">Add Prices</a>
                                        <form action="{{ route('funds.destroy', $fund->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE') <!-- Método HTTP usado para deletar o recurso -->
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
