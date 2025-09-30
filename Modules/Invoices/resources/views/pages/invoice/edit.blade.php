<x-app-layout>
    <div class="container mx-auto py-10 px-4">
        <form action="{{ route('invoice.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')


            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Invoice #{{ $invoice->invoice_number }}</h2>
            </div>

            <!-- Summary and Logo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white border p-4 rounded-lg mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Summary</label>
                    <input type="text" name="title" value="{{ old('title', $invoice->title) }}"
                        placeholder="Summary (e.g. project name, description of invoice)"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-indigo-500">
                    <textarea name="description" rows="2" placeholder="Detailed description..."
                        class="w-full mt-2 border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-indigo-500">{{ old('description', $invoice->description) }}</textarea>
                </div>
                <div class="flex items-center justify-center">
                    <img src="{{ tenant_asset($companySettings->logo) }}" alt="Company Logo"
                        class="h-24 object-contain">
                </div>
            </div>

            <!-- Invoice Information -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white border p-4 rounded-lg mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Customer</label>
                    <select name="client_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
                        <option value="">Select Customer</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Currency</label>
                    <input type="text" name="currency" value="{{ old('currency', $invoice->currency) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Invoice Number</label>
                    <input type="text" name="invoice_number"
                        value="{{ old('invoice_number', $invoice->invoice_number) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">PO/SO Number</label>
                    <input type="text" name="po_so_number" value="{{ old('po_so_number', $invoice->po_so_number) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Invoice Date</label>
                    <input type="date" name="invoice_date"
                        value="{{ old('invoice_date', $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') : '') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Due Date</label>
                    <input type="date" name="due_date"
                        value="{{ old('due_date', $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') : '') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
                </div>
            </div>

            <!-- Dynamic Product Lines -->
            <div class="bg-white border p-4 rounded-lg mb-6" x-data="invoiceProductData()" x-init="init()">
                <h3 class="text-md font-semibold text-gray-700 mb-4">Products and Services</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700 border overflow-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Project</th>
                                <th class="px-4 py-2 text-left">Description</th>
                                <th class="px-4 py-2 text-left">Qty</th>
                                <th class="px-4 py-2 text-left">Price</th>
                                <th class="px-4 py-2 text-left">Amount</th>
                                <th class="px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in products" :key="index">
                                <tr class="border-t">
                                    <!-- Project dropdown -->
                                    <td class="px-2 py-2 align-top" style="overflow: hidden;">
                                        <div x-data="{ search: item.project_name || '', showDropdown: false }" class="relative w-48" x-cloak>
                                            <input type="text" x-model="search" @focus="showDropdown = true"
                                                @input="showDropdown = true" @click.away="showDropdown = false"
                                                placeholder="Search project..."
                                                class="w-full border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring focus:ring-indigo-300">

                                            <ul x-show="showDropdown" x-transition
                                                class="left-0 z-50 w-full mt-1 bg-white border border-gray-300 rounded shadow-lg max-h-60 overflow-y-auto">
                                                @foreach ($projects as $project)
                                                    <li class="px-3 py-1 hover:bg-indigo-100 cursor-pointer"
                                                        @click="item.project_id = '{{ $project->id }}'; search = '{{ $project->name }}'; item.project_name = '{{ $project->name }}'; showDropdown = false">
                                                        {{ $project->name }}
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <input type="hidden" :name="`products[${index}][id]`"
                                                :value="item.id">
                                            <input type="hidden" :name="`products[${index}][project_id]`"
                                                :value="item.project_id">
                                        </div>
                                    </td>

                                    <!-- Description -->
                                    <td class="px-2 py-2">
                                        <input type="text" :name="`products[${index}][description]`"
                                            x-model="item.description" placeholder="Description"
                                            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring focus:ring-indigo-300">
                                    </td>

                                    <!-- Quantity -->
                                    <td class="px-2 py-2">
                                        <input type="number" min="0" step="1"
                                            :name="`products[${index}][quantity]`" x-model.number="item.quantity"
                                            @input="calculateTotals()" placeholder="Qty"
                                            class="w-20 border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring focus:ring-indigo-300">
                                    </td>

                                    <!-- Price -->
                                    <td class="px-2 py-2">
                                        <input type="number" step="0.01" min="0"
                                            :name="`products[${index}][price]`" x-model.number="item.price"
                                            @input="calculateTotals()" placeholder="Price"
                                            class="w-24 border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring focus:ring-indigo-300">
                                    </td>

                                    <!-- Amount -->
                                    <td class="px-2 py-2">
                                        <input type="number" step="0.01" readonly
                                            :value="(item.quantity * item.price).toFixed(2)"
                                            class="w-24 bg-gray-100 border border-gray-300 rounded px-2 py-1 text-gray-600 cursor-not-allowed">
                                    </td>

                                    <!-- Remove button -->
                                    <td class="px-2 py-2">
                                        <button type="button" @click="removeProduct(index)"
                                            class="text-red-600 hover:text-red-800 text-xs font-medium">
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <button type="button" class="mt-4 text-sm text-indigo-600 hover:underline hover:text-indigo-800"
                    @click="addProduct()">
                    + Add another product
                </button>

                <!-- Totals -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6 border-t pt-4">
                    <div class="sm:col-span-2"></div>

                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <label class="text-gray-700 font-medium">Subtotal:</label>
                            <span x-text="subtotal.toFixed(2)"></span>
                            <input type="hidden" name="subtotal" :value="subtotal.toFixed(2)">
                        </div>

                        <div class="flex justify-between font-semibold text-lg border-t pt-2">
                            <label class="text-gray-800">Total:</label>
                            <span x-text="total.toFixed(2)"></span>
                            <input type="hidden" name="total" :value="total.toFixed(2)">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes & Footer -->
            <div class="bg-white border p-4 rounded-lg mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" rows="4" class="w-full border rounded px-3 py-2">{{ old('notes', $invoice->notes) }}</textarea>
                </div>
                <div>
                    <label for="instructions" class="block text-sm font-medium text-gray-700">Payment
                        Instructions</label>
                    <textarea name="instructions" rows="4" class="w-full border rounded px-3 py-2">{{ old('instructions', $invoice->instructions) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label for="footer" class="block text-sm font-medium text-gray-700">Footer</label>
                    <textarea name="footer" rows="2" class="w-full border rounded px-3 py-2">{{ old('footer', $invoice->footer) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('invoice.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg">
                    Update Invoice
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('invoiceProductData', () => ({
                products: @json($products),
                subtotal: {{ $invoice->subtotal }},
                total: {{ $invoice->total }},

                init() {
                    // Initialize if products is empty
                    if (this.products.length === 0) {
                        this.addProduct();
                    }
                },

                addProduct() {
                    this.products.push({
                        id: null,
                        project_id: '',
                        project_name: '',
                        description: '',
                        quantity: 1,
                        price: 0
                    });
                },

                removeProduct(index) {
                    this.products.splice(index, 1);
                    this.calculateTotals();
                },

                calculateTotals() {
                    this.subtotal = this.products.reduce((sum, product) => {
                        return sum + (product.quantity * product.price);
                    }, 0);

                    this.total = this.subtotal;
                }
            }));
        });
    </script>
</x-app-layout>
