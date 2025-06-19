<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use App\Models\SalesOrderItem;
use Illuminate\Support\Facades\DB;





class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $orders = SalesOrder::with('user')->latest()->paginate(10);
    return view('sales-orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        return view('sales-orders.create', compact('products'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesOrder  $salesOrder
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {
        // Step 1: Validate incoming data
        $validated = $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:0',
            'products.*.price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        // Step 2: Filter out items where quantity is zero
        $filteredProducts = collect($validated['products'])
            ->filter(fn ($item) => $item['quantity'] > 0)
            ->values()
            ->all();

        if (empty($filteredProducts)) {
            return back()->withErrors(['error' => 'Please select at least one product with quantity > 0.']);
        }

        // Step 3: Begin transaction
        DB::beginTransaction();

        try {
            // Step 4: Create the sales order
            $order = SalesOrder::create([
                'user_id' => auth()->id(),
                'total' => 0 // will update after calculating
            ]);

            $total = 0;

            // Step 5: Loop through selected products
            foreach ($filteredProducts as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                // Add order item
                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'], // snapshot of price
                ]);

                // Reduce stock
                $product->decrement('quantity', $item['quantity']);

                // Update total
                $total += $item['quantity'] * $item['price'];
            }

            // Step 6: Update total in order
            $order->update(['total' => $total]);

            DB::commit();

            return redirect()->route('sales-orders.show', $order->id)
                            ->with('success', 'Sales order created successfully!');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to save order: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $order = SalesOrder::with(['items.product', 'user'])->findOrFail($id);
        return view('sales-orders.show', compact('order'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesOrder  $salesOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesOrder  $salesOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesOrder  $salesOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesOrder $salesOrder)
    {
        //
    }

    public function downloadPDF($id) {
    $order = SalesOrder::with('items.product')->findOrFail($id);
    $pdf = Pdf::loadView('pdf.invoice', compact('order'));
    return $pdf->download('invoice.pdf');
    }
}
