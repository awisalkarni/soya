<?php

namespace App\Http\Modals\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;


class SalesForm extends Component
{
    public $company_id = 1; // Default to a specific company, can be dynamic
    public $payment_method_id = 1; // Example: Default payment method, can be dynamic
    public $products;
    public $cart = [];
    public $totalAmount = 0;
    public $client_id = 1; // Default to "walk in"

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::where('company_id', $this->company_id)->get();
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) return;

        // Check if the product is already in the cart
        $index = array_search($productId, array_column($this->cart, 'id'));

        if ($index === false) {
            // Add new product to cart
            $this->cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'unit_price' => $product->price,
                'total' => $product->price,
            ];
        } else {
            // Update existing product in cart (e.g., increase quantity)
            $this->cart[$index]['quantity'] += 1;
            $this->cart[$index]['total'] = $this->cart[$index]['quantity'] * $this->cart[$index]['unit_price'];
        }

        $this->calculateTotal();
    }

    public function updateCart($index, $field, $value)
    {
        if ($field === 'quantity') {
            $this->cart[$index]['quantity'] = $value;
            $this->cart[$index]['total'] = $this->cart[$index]['quantity'] * $this->cart[$index]['unit_price'];
        } elseif ($field === 'unit_price') {
            $this->cart[$index]['unit_price'] = $value;
            $this->cart[$index]['total'] = $this->cart[$index]['quantity'] * $this->cart[$index]['unit_price'];
        }

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalAmount = array_sum(array_column($this->cart, 'total'));
    }

    public function saveSales()
    {
        $sale = Sale::create([
            'company_id' => $this->company_id,
            'payment_method_id' => $this->payment_method_id,
            'total' => $this->totalAmount,
        ]);

        foreach ($this->cart as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['id'],
                'client_id' => $this->client_id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['total'],
            ]);
        }

        // Clear the cart after saving
        $this->cart = [];
        $this->totalAmount = 0;

        session()->flash('message', 'Sales saved successfully.');
    }

    public function render()
    {
        return view('livewire.modals.sales-form');
    }
}
