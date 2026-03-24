<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

class AdminDashboardController extends Controller
{
    public function analytics(Request $request)
    {
        // Yearly Sales
        $yearlyData = OrderItem::selectRaw('YEAR(created_at) as year, SUM(price * quantity) as total')
            ->groupBy('year')
            ->pluck('total', 'year');

        // Sales Range
        $start = $request->start_date ?? now()->subDays(30)->toDateString();
        $end   = $request->end_date ?? now()->toDateString();

        $rangeData = OrderItem::whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as date, SUM(price * quantity) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        // Product Contribution
        $productData = OrderItem::with('product')
            ->selectRaw('product_id, SUM(price * quantity) as total')
            ->groupBy('product_id')
            ->get()
            ->pluck('total', 'product.name');

        return view('admin.reports.analytics', compact('yearlyData', 'rangeData', 'productData', 'start', 'end'));
    }
}
