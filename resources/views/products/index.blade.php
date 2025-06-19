<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            📦 Product List
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 text-right">
            <a href="{{ route('products.create') }}"
               class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Add New Product
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b">Name</th>
                        <th class="px-4 py-2 border-b">SKU</th>
                        <th class="px-4 py-2 border-b">Price</th>
                        <th class="px-4 py-2 border-b">Quantity</th>
                        <th class="px-4 py-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $product->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $product->sku }}</td>
                            <td class="px-4 py-2 border-b">₹{{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-2 border-b">{{ $product->quantity }}</td>
                            <td class="px-4 py-2 border-b space-x-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
