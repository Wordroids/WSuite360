<x-app-layout>
    <div class="container mx-auto my-5 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">
            Create Invoice
        </h2>

        <form action="#" method="POST">
            @csrf

            <div class="mb-4">
                <label for="invoice_no" class="block text-gray-700 font-medium mb-2">Invoice No</label>
                <input type="text" id="invoice_no" name="invoice_no"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
                <input type="date" id="date" name="date"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="nature_of_service" class="block text-gray-700 font-medium mb-2">Nature of Service</label>
                <input type="text" id="nature_of_service" name="nature_of_service"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="due_date" class="block text-gray-700 font-medium mb-2">Due Date</label>
                <input type="date" id="due_date" name="due_date"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            <h4 class="text-lg font-semibold text-gray-700 mt-6 mb-4">Shift Details</h4>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="oic_shifts_day" class="block text-gray-700 font-medium mb-2">OIC Shifts Day</label>
                    <input type="number" id="oic_shifts_day" name="oic_shifts_day"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
                <div>
                    <label for="oic_shifts_night" class="block text-gray-700 font-medium mb-2">OIC Shifts Night</label>
                    <input type="number" id="oic_shifts_night" name="oic_shifts_night"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
                <div>
                    <label for="oic_ot_hrs" class="block text-gray-700 font-medium mb-2">OIC O/T Hrs</label>
                    <input type="number" id="oic_ot_hrs" name="oic_ot_hrs"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
                <div>
                    <label for="so_shifts_day" class="block text-gray-700 font-medium mb-2">SO Shifts Day</label>
                    <input type="number" id="so_shifts_day" name="so_shifts_day"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
                <div>
                    <label for="so_shifts_night" class="block text-gray-700 font-medium mb-2">SO Shifts Night</label>
                    <input type="number" id="so_shifts_night" name="so_shifts_night"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
                <div>
                    <label for="so_ot_hrs" class="block text-gray-700 font-medium mb-2">SO O/T Hrs</label>
                    <input type="number" id="so_ot_hrs" name="so_ot_hrs"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
                <div>
                    <label for="lso_shifts_day" class="block text-gray-700 font-medium mb-2">LSO Shifts Day</label>
                    <input type="number" id="lso_shifts_day" name="lso_shifts_day"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
                <div>
                    <label for="lso_shifts_night" class="block text-gray-700 font-medium mb-2">LSO Shifts Night</label>
                    <input type="number" id="lso_shifts_night" name="lso_shifts_night"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
                <div>
                    <label for="total_amount" class="block text-gray-700 font-medium mb-2">Total Amount (Rs)</label>
                    <input type="number" id="total_amount" name="total_amount"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Create Invoice
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
