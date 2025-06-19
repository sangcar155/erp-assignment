<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\SalesItem;



class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $orders = SalesOrder::latest()->paginate(10);
     return view('sales-orders.index', compact('orders'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get(); // only in-stock
        return view('sales-orders.create', compact('products'));
    }


    /**
     * Store a newly created resource in storage.
     */
            public function store(Request $request)
        {
            // ✅ Validate
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'order_date' => 'required|date',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'total' => 'required|numeric|min:0',
            ]);

            DB::beginTransaction();

            try {
                // ✅ Step 1: Create sales order
                $order = SalesOrder::create([
                    'customer_name' => $request->customer_name,
                    'order_date' => $request->order_date,
                    'total' => $request->total,
                ]);
                // dd($order);

                // ✅ Step 2: Loop through items
                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['product_id']);

                    if ($product->quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for: {$product->name}");
                    }

                    // ✅ Step 3: Save sales item
                    SalesItem::create([
                        'sales_order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'subtotal' => $product->price * $item['quantity'],
                    ]);

                    // ✅ Step 4: Reduce inventory
                    $product->decrement('quantity', $item['quantity']);
                }

                DB::commit();
                return redirect()->route('sales-orders.index')->with('success', 'Sales order created successfully.');

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', $e->getMessage())->withInput();
            }
        }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = SalesOrder::with('items.product')->findOrFail($id);
        return view('sales-orders.show', compact('order'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder)
    {
        //
    }

    public function downloadPDF($id)
    {
        $order = SalesOrder::with('items.product')->findOrFail($id);
        $pdf = Pdf::loadView('pdf.invoice', compact('order'));

        return $pdf->download('SalesOrder_'.$order->id.'.pdf');
    }
}
