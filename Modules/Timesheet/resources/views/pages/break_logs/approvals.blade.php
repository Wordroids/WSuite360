<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Break Log Approvals') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Employee</th>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Break Time</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($breakLogs as $log)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $log->employee->name }}</td>
                        <td class="px-4 py-2">{{ $log->date }}</td>
                        <td class="px-4 py-2">{{ $log->break_time }} mins</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <form action="{{ route('break_logs.approve', $log->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700">
                                    Approve
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
