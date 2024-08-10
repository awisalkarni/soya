<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\PaymentMethod;
use App\Models\Client;

class SalesForm extends Component
{
    public $company_id;
    public $payment_method_id = 1; // Default payment method
    public $client_id = 1; // Default to "walk in"
    public $products;
    public $cart = [];
    public $totalAmount = 0;
    public $paymentMethods = [];
    public $clients = [];

    public function mount($companyId)
    {
        $this->company_id = $companyId;
        $this->loadProducts();
        $this->loadPaymentMethodsAndClients();
    }

    public function loadProducts()
    {
        $this->products = Product::where('company_id', $this->company_id)->get();
    }

    public function loadPaymentMethodsAndClients()
    {
        $this->paymentMethods = PaymentMethod::where('company_id', $this->company_id)->get();
        $this->clients = Client::where('company_id', $this->company_id)->get();
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
        // Check if the cart is empty
        if (empty($this->cart)) {
            session()->flash('error', 'Cannot save sales. The cart is empty.');
            return;
        }

        // Create a new sale record with client_id, company_id, payment_method_id, and total
        $sale = Sale::create([
            'company_id' => $this->company_id,
            'client_id' => $this->client_id,
            'payment_method_id' => $this->payment_method_id,
            'total' => $this->totalAmount,
        ]);

        // Loop through the cart items and create sale items associated with the sale
        foreach ($this->cart as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['id'],
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
        return view('livewire.sales.sales-form');
    }
}
