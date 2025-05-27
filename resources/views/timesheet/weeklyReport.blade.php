<x-app-layout>
    <div class="p-6 bg-gray-100 min-h-screen">
        <h1 class="text-2xl font-bold mb-4">Weekly Report</h1>


        <div class="mt-5 mb-4 flex space-x-2  items-center">

            <button onclick="window.location.href='{{ route('timesheet.chartsView') }}'"
                class="px-4 py-2 text-sm font-medium  bg-gray-200 hover:bg-gray-300 rounded-lg">Summary</button>
            <button onclick="window.location.href='{{ route('timesheet.detailedReport') }}'"
                class="px-4 py-2 text-sm font-medium  bg-gray-200 hover:bg-gray-300 rounded-lg ">Detailed</button>
            <button onclick="window.location.href='{{ route('timesheet.weeklyReport') }}'"
                class="px-4 py-2 text-sm font-medium  bg-indigo-700 text-white rounded-lg hover:bg-indigo-700 transition">Weekly</button>
            <button class="px-4 py-2 text-sm font-medium bg-gray-200 hover:bg-gray-300 rounded-lg">Shared</button>

        </div>

        <!-- Time Tracking Table -->

            <div class="text-gray-700 font-semibold text-lg">Total Hours: <span
                    class="text-black font-bold">48:30</span></div>

            <div class="overflow-x-auto rounded-lg shadow-lg mt-3">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">#</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Project</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-700 border-b">Mo</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-700 border-b">Tu</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-700 border-b">We</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-700 border-b">Th</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-700 border-b">Fr</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-700 border-b">Sa</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-700 border-b">Su</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-700 border-b">Total</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $dummyData = [
                                ['id' => 1, 'project' => 'Website Redesign', 'hours' => [5, 4, 6, 5, 4, 3, 0]],
                                ['id' => 2, 'project' => 'Mobile App Development', 'hours' => [3, 5, 4, 4, 6, 2, 1]],
                                ['id' => 3, 'project' => 'API Integration', 'hours' => [2, 3, 5, 6, 4, 3, 2]],
                            ];
                        @endphp

                        @foreach ($dummyData as $entry)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800 text-center">{{ $entry['id'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 font-semibold">{{ $entry['project'] }}</td>
                                @foreach ($entry['hours'] as $hour)
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $hour }}h</td>
                                @endforeach
                                <td class="px-6 py-4 text-sm text-gray-800 font-bold">
                                    {{ array_sum($entry['hours']) }}h
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td class="px-6 py-4 font-semibold">Total:</td>
                            <td class="px-6 py-4"></td>
                            @php
                                $totals = array_reduce(
                                    $dummyData,
                                    function ($carry, $entry) {
                                        foreach ($entry['hours'] as $index => $hour) {
                                            $carry[$index] = ($carry[$index] ?? 0) + $hour;
                                        }
                                        return $carry;
                                    },
                                    [],
                                );
                            @endphp
                            @foreach ($totals as $total)
                                <td class="px-6 py-4">{{ $total }}h</td>
                            @endforeach
                            <td class="px-6 py-4 font-bold">{{ array_sum($totals) }}h</td>
                           
                        </tr>
                    </tfoot>
                </table>
            </div>

    </div>
</x-app-layout>

<!-- Delete Confirmation -->
<script>
    function confirmDeletion(entryId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#4338CA',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                alert('Deleted entry ID: ' + entryId);
            }
        });
    }
</script>
