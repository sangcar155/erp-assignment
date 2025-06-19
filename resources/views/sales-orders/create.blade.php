<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            🧾 Create Sales Order
        </h2>
    </x-slot>

    <div class="py-6 px-6">
      <form method="POST" action="{{ route('sales-orders.store') }}">
       @csrf

            <!-- Customer & Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block font-medium">Customer Name</label>
                    <input type="text" name="customer_name" required
                           class="w-full px-3 py-2 border rounded border-gray-300">
                </div>
                <div>
                    <label class="block font-medium">Order Date</label>
                    <input type="date" name="order_date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-3 py-2 border rounded border-gray-300">
                </div>
            </div>

            <!-- Dynamic Products Table -->
            <div>
                <label class="block font-medium mb-2">Select Products</label>
                <table class="w-full text-sm border border-gray-300 mb-4">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2">Product</th>
                            <th class="px-3 py-2">Price</th>
                            <th class="px-3 py-2">Quantity</th>
                            <th class="px-3 py-2">Subtotal</th>
                            <th class="px-3 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="product-rows">
                        <!-- JS will inject rows here -->
                    </tbody>
                </table>

                <button type="button" id="add-product" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Add Product
                </button>
            </div>

            <!-- Total -->
            <div class="mb-6 text-right font-semibold text-lg">
                Total: ₹<span id="total">0.00</span>
                <input type="hidden" name="total" id="total-input" value="0">
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    ✅ Confirm Order
                </button>
            </div>
        </form>
    </div>

    <!-- JS for dynamic rows -->
    <script>
        const products = @json($products);
        let rowIndex = 0;

        document.getElementById('add-product').addEventListener('click', () => {
            const row = document.createElement('tr');
            const id = rowIndex++;

            row.innerHTML = `
                <td class="px-3 py-2">
                    <select name="items[${id}][product_id]" class="w-full border rounded border-gray-300" required>
                        <option value="">-- Select --</option>
                        ${products.map(p =>
                            `<option value="${p.id}" data-price="${p.price}">${p.name}</option>`
                        ).join('')}
                    </select>
                </td>
                <td class="px-3 py-2 text-center price">0</td>
                <td class="px-3 py-2">
                    <input type="number" name="items[${id}][quantity]" value="1" min="1"
                           class="w-20 quantity border rounded px-2 py-1">
                </td>
                <td class="px-3 py-2 text-center subtotal">0</td>
                <td class="px-3 py-2 text-center">
                    <button type="button" class="remove px-2 text-red-600">✖</button>
                </td>
            `;

            document.getElementById('product-rows').appendChild(row);
            updateListeners();
        });

        function updateListeners() {
            document.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', updateRow);
            });
            document.querySelectorAll('.quantity').forEach(input => {
                input.addEventListener('input', updateRow);
            });
            document.querySelectorAll('.remove').forEach(btn => {
                btn.addEventListener('click', e => {
                    e.target.closest('tr').remove();
                    calculateTotal();
                });
            });
        }

        function updateRow(e) {
            const row = e.target.closest('tr');
            const select = row.querySelector('select');
            const quantity = parseFloat(row.querySelector('.quantity').value) || 1;
            const price = parseFloat(select.selectedOptions[0].dataset.price || 0);

            row.querySelector('.price').innerText = price.toFixed(2);
            row.querySelector('.subtotal').innerText = (price * quantity).toFixed(2);

            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(td => {
                total += parseFloat(td.innerText) || 0;
            });
            document.getElementById('total').innerText = total.toFixed(2);
            document.getElementById('total-input').value = total.toFixed(2);
        }
    </script>
</x-app-layout>
 