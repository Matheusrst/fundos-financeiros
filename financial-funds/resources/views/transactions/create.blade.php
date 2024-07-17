<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Transaction Type -->
                            <div>
                                <x-label for="type" :value="__('Transaction Type')" />
                                <select name="type" id="type" class="block mt-1 w-full">
                                    <option value="buy" {{ old('type') == 'buy' ? 'selected' : '' }}>Buy</option>
                                    <option value="sell" {{ old('type') == 'sell' ? 'selected' : '' }}>Sell</option>
                                </select>
                            </div>

                            <!-- Asset Type -->
                            <div>
                                <x-label for="asset_type" :value="__('Asset Type')" />
                                <select name="asset_type" id="asset_type" class="block mt-1 w-full" onchange="updateAssets()">
                                    <option value="stock" {{ old('asset_type') == 'stock' ? 'selected' : '' }}>Stock</option>
                                    <option value="fund" {{ old('asset_type') == 'fund' ? 'selected' : '' }}>Fund</option>
                                </select>
                            </div>

                            <!-- Asset -->
                            <div>
                                <x-label for="asset_id" :value="__('Asset')" />
                                <select name="asset_id" id="asset_id" class="block mt-1 w-full" onchange="updatePrice()">
                                    <!-- Options will be populated by JavaScript -->
                                </select>
                            </div>

                            <!-- Price -->
                            <div>
                                <x-label for="price" :value="__('Price')" />
                                <x-input id="price" class="block mt-1 w-full" type="text" name="price" readonly />
                            </div>

                            <!-- Quantity -->
                            <div>
                                <x-label for="quantity" :value="__('Quantity')" />
                                <x-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" required />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to dynamically update the asset dropdown and price
        const stocks = @json($stocks);
        const funds = @json($funds);

        function updateAssets() {
            const assetType = document.getElementById('asset_type').value;
            const assetSelect = document.getElementById('asset_id');

            // Clear the current options
            assetSelect.innerHTML = '';

            // Populate the options based on the selected asset type
            let assets = [];
            if (assetType === 'stock') {
                assets = stocks;
            } else if (assetType === 'fund') {
                assets = funds;
            }

            assets.forEach(asset => {
                const option = document.createElement('option');
                option.value = asset.id;
                option.textContent = asset.name;
                assetSelect.appendChild(option);
            });

            // Update the price field based on the selected asset
            updatePrice();
        }

        function updatePrice() {
            const assetType = document.getElementById('asset_type').value;
            const assetId = document.getElementById('asset_id').value;
            let assets = [];

            if (assetType === 'stock') {
                assets = stocks;
            } else if (assetType === 'fund') {
                assets = funds;
            }

            const selectedAsset = assets.find(asset => asset.id == assetId);

            // Update the price field
            if (selectedAsset) {
                document.getElementById('price').value = selectedAsset.price;
            } else {
                document.getElementById('price').value = '';
            }
        }

        // Initialize the asset dropdown and price field on page load
        document.addEventListener('DOMContentLoaded', function () {
            updateAssets();
        });
    </script>
</x-app-layout>
