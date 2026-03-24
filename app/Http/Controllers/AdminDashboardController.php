<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\Order;
use App\Models\OrderItem;

class AdminDashboardController extends Controller
{
    public function analytics(Request $request)
    {
        // Yearly Sales Chart
        $yearlySalesChart = new LaravelChart([
            'chart_title' => 'Yearly Sales',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'year',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total',
            'chart_type' => 'bar',
            'conditions' => [
                ['condition' => 'true', 'color' => '0,123,255', 'fill' => true],
            ],
        ]);

        // Sales Range Chart
        $start = $request->start_date;
        $end   = $request->end_date;

        $salesRangeChart = new LaravelChart([
            'chart_title' => 'Sales in Date Range',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'conditions' => [
                ['field' => 'created_at', 'operator' => '>=', 'value' => $start, 'color' => '255,99,132', 'fill' => true],
                ['field' => 'created_at', 'operator' => '<=', 'value' => $end, 'color' => '255,99,132', 'fill' => true],
            ],
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total',
            'chart_type' => 'bar',
            
        ]);

        // Product Contribution Pie Chart
        $productSalesChart = new LaravelChart([
            'chart_title' => 'Product Contribution',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\OrderItem',
            'relationship_name' => 'product',
            'group_by_field' => 'name',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'price',
            'chart_type' => 'pie',
            'conditions' => [
                ['condition' => 'true', 'color' => '54,162,235', 'fill' => true],
            ],
        ]);

        return view('admin.reports.analytics', compact(
            'yearlySalesChart',
            'salesRangeChart',
            'productSalesChart'
        ));
    }
}














