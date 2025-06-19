<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            ✏️ Update Product
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="max-w-xl mx-auto bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('products.update', $product) }}">
                @csrf
                @method('PUT')

                @include('products.partials.form', ['product' => $product])

                <div class="mt-4">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('products.index') }}"
                   class="text-blue-600 hover:underline">← Back to Product List</a>
            </div>
        </div>
    </div>
</x-app-layout>
