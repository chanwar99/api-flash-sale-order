<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    public function addProductToOrder(Request $request, $orderId)
    {
        // Validasi input

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Check if the product is already in the order
        $existingOrderItem = $order->products()->where('product_id', $productId)->first();

        if ($existingOrderItem) {
            // Update the quantity and total order
            $existingOrderItem->quantity += $quantity;
            $existingOrderItem->total_order += $quantity * $product->price;
            $existingOrderItem->save();
        } else {
            // Create a new order item
            $orderItem = new Order();
            $orderItem->product_id = $productId;
            $orderItem->quantity = $quantity;
            $orderItem->total_order = $quantity * $product->price;
            $order->products()->save($orderItem);
        }

        // Update the total order amount in the order
        $order->total_order += $quantity * $product->price;
        $order->save();

        return response()->json($order);
    }
}