<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    /**
     * Lấy danh sách tất cả mặt hàng trong đơn hàng.
     */
    public function index()
    {
        $items = OrderItem::all();
        return response()->json(['success' => true, 'data' => $items], 200);
    }

    /**
     * Lấy thông tin chi tiết một mặt hàng.
     */
    public function show($id)
    {
        $item = OrderItem::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Order item not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $item], 200);
    }

    /**
     * Tạo mặt hàng mới.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|integer',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        $item = OrderItem::create($validated);

        return response()->json(['success' => true, 'data' => $item], 201);
    }

    /**
     * Cập nhật mặt hàng.
     */
    public function update(Request $request, $id)
    {
        $item = OrderItem::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Order item not found'], 404);
        }

        $validated = $request->validate([
            'quantity' => 'sometimes|integer|min:1',
            'unit_price' => 'sometimes|numeric|min:0',
        ]);

        if (isset($validated['quantity']) || isset($validated['unit_price'])) {
            $quantity = $validated['quantity'] ?? $item->quantity;
            $unit_price = $validated['unit_price'] ?? $item->unit_price;
            $validated['total_price'] = $quantity * $unit_price;
        }

        $item->update($validated);

        return response()->json(['success' => true, 'data' => $item], 200);
    }

    /**
     * Xóa một mặt hàng trong đơn hàng.
     */
    public function destroy($id)
    {
        $item = OrderItem::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Order item not found'], 404);
        }

        $item->delete();

        return response()->json(['success' => true, 'message' => 'Order item deleted successfully'], 200);
    }
}
