<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->get();
        return response()->json($orders);
    }

    public function addProductToOrder(Request $request)
    {
        // Validasi input
        $order = new Order();

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        // Check if the product is already in the order
        $existingProductItem = $order->where('product_id', $productId)->first();

        if ($existingProductItem) {
            // Update the quantity and total order
            $existingProductItem->quantity += $quantity;
            $existingProductItem->total_order += $quantity * $product->price;
            $existingProductItem->save();
            return response()->json($existingProductItem);
        } else {
            // Create a new product item
            $order->product_id = $productId;
            $order->quantity = $quantity;
            $order->total_order = $quantity * $product->price;
            $order->save();
            return response()->json($order);
        }
    }
}