<div class="p-4 max-w-lg mx-auto">
    <div class="mb-4">
        <h2 class="text-lg font-bold">Products</h2>
        <div class="grid grid-cols-2 gap-2">
            @foreach($products as $product)
            <button wire:click="addToCart({{ $product->id }})" class="p-2 border rounded text-center bg-gray-200">
                {{ $product->name }} <br> RM{{ number_format($product->price, 2) }}
            </button>
            @endforeach
        </div>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-bold">Cart</h2>
        <table class="w-full border-collapse border">
            <thead>
                <tr class="border-b">
                    <th class="p-2 text-left">Product</th>
                    <th class="p-2 text-center">Qty</th>
                    <th class="p-2 text-right">Price</th>
                    <th class="p-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $index => $item)
                <tr class="border-b">
                    <td class="p-2">{{ $item['name'] }}</td>
                    <td class="p-2 text-center">
                        <button wire:click="updateCart({{ $index }}, 'quantity', {{ $item['quantity'] - 1 }})"
                            class="px-1">-</button>
                        <input type="text" wire:model.lazy="cart.{{ $index }}.quantity" class="w-8 text-center">
                        <button wire:click="updateCart({{ $index }}, 'quantity', {{ $item['quantity'] + 1 }})"
                            class="px-1">+</button>
                    </td>
                    <td class="p-2 text-right">
                        <input type="text" wire:model.lazy="cart.{{ $index }}.unit_price" class="w-16 text-right">
                    </td>
                    <td class="p-2 text-right">
                        RM{{ number_format($item['total'], 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-right font-bold text-xl mb-4">
        Total: RM{{ number_format($totalAmount, 2) }}
    </div>

    <button wire:click="saveSales" class="w-full py-2 bg-blue-500 text-white rounded">Save</button>

    @if (session()->has('message'))
    <div class="mt-2 text-green-600">
        {{ session('message') }}
    </div>
    @endif
</div>
