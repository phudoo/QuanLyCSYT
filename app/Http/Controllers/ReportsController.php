<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdersReport;
use App\Models\ProductReport;
use App\Models\Order;
use App\Models\Product;

class ReportsController extends Controller
{
    public function getAllProductReports()
    {
        return ProductReport::all();
    }

    public function getProductReportById($id)
    {
        return ProductReport::findOrFail($id);
    }

    public function getAllOrderReports()
    {
        return OrdersReport::all();
    }

    public function getOrderReportById($id)
    {
        return OrdersReport::findOrFail($id);
    }

    public function createProductReport(Request $request)
    {
        $data = $request->validate([
            'order_report_id' => 'required|integer',
            'product_id' => 'required|integer',
            'total_sold' => 'required|integer',
            'revenue' => 'required|numeric',
            'cost' => 'required|numeric',
            'profit' => 'required|numeric',
        ]);
        return ProductReport::create($data);
    }

    public function createOrderReport(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        
        // Calculate totals
        $totalRevenue = $order->total_amount;
        $totalCost = 0;
        
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            $totalCost += ($product->cost ?? 0) * $item->quantity;
        }
        
        $totalProfit = $totalRevenue - $totalCost;

        // Create order report
        $orderReport = OrdersReport::create([
            'order_id' => $order->id,
            'total_revenue' => $totalRevenue,
            'total_cost' => $totalCost,
            'total_profit' => $totalProfit
        ]);

        // Create product reports
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            $revenue = $item->total_price;
            $cost = ($product->cost ?? 0) * $item->quantity;
            
            ProductReport::create([
                'order_report_id' => $orderReport->id,
                'product_id' => $item->product_id,
                'total_sold' => $item->quantity,
                'revenue' => $revenue,
                'cost' => $cost,
                'profit' => $revenue - $cost
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $orderReport->load('productReports')
        ], 201);
    }

    public function deleteProductReport($id)
    {
        $report = ProductReport::findOrFail($id);
        $report->delete();
        return response()->json(['message' => 'Product report deleted successfully']);
    }

    public function deleteOrderReport($id)
    {
        $report = OrdersReport::findOrFail($id);
        $report->delete();
        return response()->json(['message' => 'Order report deleted successfully']);
    }
}
