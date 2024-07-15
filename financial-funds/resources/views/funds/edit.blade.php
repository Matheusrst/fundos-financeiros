<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Fund') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('funds.update', $fund->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Fund Name</label>
                            <input type="text" id="name" name="name" class="form-input mt-1 block w-full" value="{{ $fund->name }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <input type="number" id="price" name="price" step="0.01" class="form-input mt-1 block w-full" value="{{ $fund->price }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="available_quantity" class="block text-sm font-medium text-gray-700">Available Quantity</label>
                            <input type="number" id="available_quantity" name="available_quantity" class="form-input mt-1 block w-full" min="0" value="{{ $fund->available_quantity }}" required>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-button>Update</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
