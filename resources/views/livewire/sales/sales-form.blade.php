<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <!-- Back to Dashboard Button -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}"
            class="inline-block bg-gray-500 text-white font-bold py-2 px-4 rounded-lg shadow hover:bg-gray-600 transition">
            Back to Dashboard
        </a>
    </div>

    <!-- Payment Method and Client Selection -->
    <div class="mb-6">
        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
        <select wire:model="payment_method_id" id="payment_method"
            class="block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @foreach($paymentMethods as $method)
            <option value="{{ $method->id }}">{{ $method->method }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-6">
        <label for="client" class="block text-sm font-medium text-gray-700 mb-2">Client</label>
        <select wire:model="client_id" id="client"
            class="block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @foreach($clients as $client)
            <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Products Section -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Products</h2>
        <div class="grid grid-cols-2 gap-4">
            @foreach($products as $product)
            <button wire:click="addToCart({{ $product->id }})"
                class="p-4 border border-gray-200 rounded-lg text-center bg-gray-50 hover:bg-gray-100 transition duration-150 ease-in-out">
                <span class="block font-semibold text-gray-700">{{ $product->name }}</span>
                <span class="block mt-2 text-gray-500">RM{{ number_format($product->price, 2) }}</span>
            </button>
            @endforeach
        </div>
    </div>

    <!-- Cart Section -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Cart</h2>
        <div class="space-y-4">
            @foreach($cart as $index => $item)
            <div class="flex flex-col md:flex-row md:justify-between items-center bg-gray-50 p-4 rounded-lg shadow">
                <div class="flex-1 md:w-1/2 text-gray-800 font-medium">{{ $item['name'] }}</div>
                <div class="flex items-center mt-4 md:mt-0">
                    <button wire:click="updateCart({{ $index }}, 'quantity', {{ $item['quantity'] - 1 }})"
                        class="px-2 py-1 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">-</button>
                    <input type="text" wire:model.lazy="cart.{{ $index }}.quantity"
                        class="w-12 p-2 text-center border border-gray-300 rounded-lg mx-2">
                    <button wire:click="updateCart({{ $index }}, 'quantity', {{ $item['quantity'] + 1 }})"
                        class="px-2 py-1 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">+</button>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between mt-4 md:mt-0 md:w-1/3 text-right">
                    <input type="text" wire:model.lazy="cart.{{ $index }}.unit_price"
                        class="w-full md:w-20 p-2 text-right border border-gray-300 rounded-lg md:mr-4">
                    <div class="mt-2 md:mt-0 text-gray-800">RM{{ number_format($item['total'], 2) }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Total and Save Button -->
    <div class="flex justify-between items-center mb-6">
        <div class="text-xl font-bold text-gray-900">Total: RM{{ number_format($totalAmount, 2) }}</div>
        <button wire:click="saveSales"
            class="py-3 px-6 bg-blue-600 text-white font-bold rounded-lg shadow hover:bg-blue-700 transition duration-150 ease-in-out">Save</button>
    </div>

    @if (session()->has('message'))
    <div class="text-center text-green-600 font-medium">
        {{ session('message') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="text-center text-red-600 font-medium mb-4">
        {{ session('error') }}
    </div>
    @endif
</div>
