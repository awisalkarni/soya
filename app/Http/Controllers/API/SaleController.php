<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function fetchSaleFormData(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Fetch the user's companies
        $companies = Company::whereHas('users', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['products', 'clients', 'paymentMethods'])->get();

        // Prepare the data
        $data = $companies->map(function($company) {
            return [
                'company' => $company,
                'products' => $company->products,
                'clients' => $company->clients,
                'payment_methods' => $company->paymentMethods,
            ];
        });

        // Return the data as JSON
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'client_id' => 'required|exists:clients,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'cart' => 'required|array',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        // Initialize the total amount
        $totalAmount = 0;

        // Calculate the total amount based on the products in the cart
        foreach ($request->cart as $item) {
            $product = Product::findOrFail($item['product_id']);
            $totalAmount += $item['quantity'] * $product->price;
        }

        // Create the sale
        $sale = Sale::create([
            'company_id' => $request->company_id,
            'client_id' => $request->client_id,
            'payment_method_id' => $request->payment_method_id,
            'total' => $totalAmount,
        ]);

        // Create sale items
        foreach ($request->cart as $item) {
            $product = Product::findOrFail($item['product_id']);
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'total' => $item['quantity'] * $product->price,
            ]);
        }

        return response()->json(['message' => 'Sale submitted successfully', 'sale' => $sale]);
    }
}
