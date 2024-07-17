<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Graphs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight">Stocks</h3>
                    <ul>
                        @foreach($stocks as $stock)
                            <li>
                                <a href="{{ route('graphs.show', ['type' => 'stock', 'id' => $stock->id]) }}" class="text-blue-500">{{ $stock->name }}</a>
                                - Current Price: ${{ $stock->price }}
                            </li>
                        @endforeach
                    </ul>
                    
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight mt-6">Funds</h3>
                    <ul>
                        @foreach($funds as $fund)
                            <li>
                                <a href="{{ route('graphs.show', ['type' => 'fund', 'id' => $fund->id]) }}" class="text-blue-500">{{ $fund->name }}</a>
                                - Current Price: ${{ $fund->price }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
