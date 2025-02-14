<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h3 class="text-lg font-semibold mb-4">My Time Logs</h3>
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Time Spent</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timeLogs as $log)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $log->date }}</td>
                        <td class="px-4 py-2">{{ $log->time_spent }} mins</td>
                        <td class="px-4 py-2">{{ ucfirst($log->status) }}</td>
                        <td class="px-4 py-2">
                            @if($log->status === 'pending')
                                <a href="{{ route('time_logs.edit', $log->id) }}" class="text-blue-500">Edit</a> |
                                <form action="{{ route('time_logs.destroy', $log->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
                                </form>
                            @else
                                <span class="text-gray-500">Locked</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h3 class="text-lg font-semibold mb-4">My Break Logs</h3>
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Break Time</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($breakLogs as $log)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $log->date }}</td>
                        <td class="px-4 py-2">{{ $log->break_time }} mins</td>
                        <td class="px-4 py-2">{{ ucfirst($log->status) }}</td>
                        <td class="px-4 py-2">
                            @if($log->status === 'pending')
                                <a href="{{ route('break_logs.edit', $log->id) }}" class="text-blue-500">Edit</a> |
                                <form action="" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
                                </form>
                            @else
                                <span class="text-gray-500">Locked</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
