<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            📋 Sales Orders
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b">Order ID</th>
                        <th class="px-4 py-2 border-b">Customer</th>
                        <th class="px-4 py-2 border-b">Date</th>
                        <th class="px-4 py-2 border-b">Total (₹)</th>
                        <th class="px-4 py-2 border-b text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">#{{ $order->id }}</td>
                            <td class="px-4 py-2 border-b">{{ $order->customer_name }}</td>
                            <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                            <td class="px-4 py-2 border-b">₹{{ number_format($order->total, 2) }}</td>
                            <td class="px-4 py-2 border-b text-right space-x-2">
                                <a href="{{ route('sales-orders.show', $order) }}"
                                   class="text-blue-600 hover:underline">View</a>
                                <a href="{{ route('sales-orders.pdf', $order->id) }}"
                                   class="text-green-600 hover:underline">PDF</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No sales orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4 px-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
