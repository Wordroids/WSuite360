<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Deactivate Employee: ') . $employee->full_name }}
        </h2>

        <form action="{{ route('employees.deactivate', $employee) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Deactivation*</label>
                <select name="reason" id="reason" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                    <option value="">Select Reason</option>
                    <option value="Resignation">Resignation</option>
                    <option value="Termination">Termination</option>
                    <option value="Retirement">Retirement</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="additional_notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                <textarea name="additional_notes" id="additional_notes" rows="3" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200">
                    Confirm Deactivation
                </button>
                <a href="{{ route('employees.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
