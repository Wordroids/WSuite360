<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Break Time') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <form action="{{ route('break_logs.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" id="date" class="mt-1 p-2 w-full border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="break_time" class="block text-sm font-medium text-gray-700">Break Time (Minutes)</label>
                <input type="number" name="break_time" id="break_time" class="mt-1 p-2 w-full border rounded-lg" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Submit Break Log
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
