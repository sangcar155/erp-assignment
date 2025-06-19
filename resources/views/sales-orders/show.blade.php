<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            🧾 Sales Order #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="bg-white rounded shadow p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Customer Info</h3>
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
                <p><strong>Total:</strong> ₹{{ number_format($order->total, 2) }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border border-gray-300">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border-b">Product</th>
                            <th class="px-4 py-2 border-b">SKU</th>
                            <th class="px-4 py-2 border-b">Price</th>
                            <th class="px-4 py-2 border-b">Quantity</th>
                            <th class="px-4 py-2 border-b">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-2 border-b">{{ $item->product->name }}</td>
                                <td class="px-4 py-2 border-b">{{ $item->product->sku }}</td>
                                <td class="px-4 py-2 border-b">₹{{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-2 border-b">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 border-b font-semibold">₹{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('sales-orders.pdf', $order->id) }}"
                   class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    📄 Download PDF
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
