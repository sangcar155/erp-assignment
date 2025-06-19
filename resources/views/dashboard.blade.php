<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            📊 Dashboard Summary
        </h2>
    </x-slot>

    <div class="py-6 px-6 space-y-6">

        {{-- Summary Cards: Show only if admin or sales --}}
        @if(in_array(auth()->user()->role, ['admin', 'sales']))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-600 text-white p-4 rounded shadow">
                    <h5 class="text-lg font-semibold">Total Sales Amount</h5>
                    <p class="text-2xl mt-2">₹{{ number_format($totalSalesAmount ?? 0, 2) }}</p>
                </div>

                <div class="bg-green-600 text-white p-4 rounded shadow">
                    <h5 class="text-lg font-semibold">Total Orders</h5>
                    <p class="text-2xl mt-2">{{ $totalOrders ?? 0 }}</p>
                </div>

                {{-- Quick Links Panel --}}
                <div class="bg-gray-100 p-4 rounded shadow text-end">
                    <h5 class="text-lg font-semibold mb-3 text-left">Quick Links</h5>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('products.index') }}"
                           class="block mb-2 px-4 py-2 bg-blue-100 text-blue-800 text-sm rounded hover:bg-blue-200">
                            🛠️ Manage Products
                        </a>
                    @endif

                    <a href="{{ route('sales-orders.index') }}"
                       class="block mb-2 px-4 py-2 bg-gray-100 text-gray-800 text-sm rounded hover:bg-gray-200">
                        📋 View Sales Orders
                    </a>

                    <a href="{{ route('sales-orders.create') }}"
                       class="block px-4 py-2 bg-green-100 text-green-800 text-sm rounded hover:bg-green-200">
                        🧾 Create Sales Order
                    </a>
                </div>
            </div>
        @else
            {{-- Message for roles without sales/dashboard access --}}
            <div class="bg-yellow-100 p-6 rounded shadow text-center text-yellow-800 font-semibold">
                Welcome, {{ auth()->user()->name }}! You currently have limited dashboard access.
            </div>
        @endif


        {{-- Low Stock Alerts: Show only for admin --}}
        @if(auth()->user()->role === 'admin')
            <div class="bg-yellow-100 border border-yellow-400 rounded shadow mt-8">
                <div class="bg-yellow-200 text-yellow-800 font-semibold px-4 py-2 rounded-t">
                    ⚠️ Low Stock Alerts
                </div>

                <div class="p-4">
                    @if(!isset($lowStockProducts))
                        <p class="text-red-600 font-medium">No product data found.</p>
                    @elseif($lowStockProducts->isEmpty())
                        <p class="text-green-600 font-medium">All products have sufficient stock.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left border border-gray-300">
                                <thead class="bg-yellow-50 text-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 border-b">Name</th>
                                        <th class="px-4 py-2 border-b">SKU</th>
                                        <th class="px-4 py-2 border-b">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $product)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $product->name }}</td>
                                            <td class="px-4 py-2">{{ $product->sku }}</td>
                                            <td class="px-4 py-2 text-red-600 font-semibold">{{ $product->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
