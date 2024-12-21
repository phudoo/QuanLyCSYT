<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdersReport;
use App\Models\ProductReport;

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
        $data = $request->validate([
            'order_id' => 'required|integer',
            'total_revenue' => 'required|numeric',
            'total_cost' => 'required|numeric',
            'total_profit' => 'required|numeric',
        ]);
        return OrdersReport::create($data);
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
