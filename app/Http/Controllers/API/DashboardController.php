<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $companyId = $request->query('company_id');

        if (!$companyId) {
            return response()->json(['message' => 'Company ID is required'], 400);
        }

        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        $todaySales = Sale::where('company_id', $companyId)
                          ->whereDate('created_at', $today)
                          ->sum('total');

        $weekSales = Sale::where('company_id', $companyId)
                         ->whereBetween('created_at', [$startOfWeek, Carbon::now()])
                         ->sum('total');

        $monthSales = Sale::where('company_id', $companyId)
                          ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
                          ->sum('total');

        return response()->json([
            'todaySales' => $todaySales,
            'weekSales' => $weekSales,
            'monthSales' => $monthSales,
        ]);
    }
}
