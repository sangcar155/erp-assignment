<?php
namespace App\Http\Controllers\Api;

use App\Models\SalesOrder;
use App\Models\SalesItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SalesOrderApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'order_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;

            $order = SalesOrder::create([
                'customer_name' => $request->customer_name,
                'order_date' => $request->order_date,
                'total' => 0, // temporary
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                SalesItem::create([
                    'sales_order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('quantity', $item['quantity']);
            }

            $order->update(['total' => $total]);

            DB::commit();

            return response()->json(['message' => 'Sales order created successfully', 'order_id' => $order->id], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $order = SalesOrder::with('items.product')->findOrFail($id);
        return response()->json($order);
    }
}
