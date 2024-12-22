<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Lấy danh sách tất cả đơn hàng
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders, 200);
    }

    // Lấy thông tin chi tiết một đơn hàng
    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json($order, 200);
    }

    // Tạo đơn hàng mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Calculate total amount
        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            if ($product->quantity < $item['quantity']) {
                return response()->json([
                    'error' => "Insufficient quantity for product {$product->name}"
                ], 400);
            }
            $totalAmount += $product->price * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Create order items and update product quantities
        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'total_price' => $product->price * $item['quantity'],
            ]);

            // Update product quantity
            $product->update([
                'quantity' => $product->quantity - $item['quantity']
            ]);
        }

        return response()->json($order->load('items'), 201);
    }

    // Cập nhật trạng thái đơn hàng
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->update(['status' => $validated['status']]);

        return response()->json($order, 200);
    }

    // Xóa một đơn hàng
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}
