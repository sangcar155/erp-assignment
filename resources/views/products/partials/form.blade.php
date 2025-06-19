<div class="space-y-4">

    <!-- Product Name -->
    <div>
        <label class="block font-medium text-gray-700">Product Name</label>
        <input type="text" name="name"
               value="{{ old('name', $product->name ?? '') }}"
               required
               class="w-full px-3 py-2 border rounded
                      @error('name') border-red-500 @else border-gray-300 @enderror">
        @error('name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- SKU -->
    <div>
        <label class="block font-medium text-gray-700">SKU</label>
        <input type="text" name="sku"
               value="{{ old('sku', $product->sku ?? '') }}"
               required
               class="w-full px-3 py-2 border rounded
                      @error('sku') border-red-500 @else border-gray-300 @enderror">
        @error('sku')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Price -->
    <div>
        <label class="block font-medium text-gray-700">Price (₹)</label>
        <input type="number" name="price"
               step="0.01" min="0" required
               value="{{ old('price', $product->price ?? '') }}"
               class="w-full px-3 py-2 border rounded
                      @error('price') border-red-500 @else border-gray-300 @enderror">
        @error('price')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Quantity -->
    <div>
        <label class="block font-medium text-gray-700">Quantity</label>
        <input type="number" name="quantity"
               step="1" min="0" required
               value="{{ old('quantity', $product->quantity ?? '') }}"
               class="w-full px-3 py-2 border rounded
                      @error('quantity') border-red-500 @else border-gray-300 @enderror">
        @error('quantity')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>
