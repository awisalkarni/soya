<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $companyId = $request->query('company_id');

        if (!$companyId) {
            return response()->json(['message' => 'Company ID is required'], 400);
        }

        $products = Product::where('company_id', $companyId)->get();

        return response()->json($products);
    }
}
