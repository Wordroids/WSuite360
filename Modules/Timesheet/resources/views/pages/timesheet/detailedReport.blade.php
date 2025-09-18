<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <div class="flex-1 p-6">

            <h1 class="text-2xl font-bold text-gray-800 leading-tight mb-4">Detailed Report</h1>

            <div class="mt-5 mb-4 flex space-x-2  items-center">


                <button onclick="window.location.href='{{ route('timesheet.chartsView') }}'"
                    class="px-4 py-2 text-sm font-medium bg-gray-200 hover:bg-gray-300 rounded-lg">Summary</button>
                <button onclick="window.location.href='{{ route('timesheet.detailedReport') }}'"
                    class="px-4 py-2 text-sm font-medium  bg-indigo-700 text-white rounded-lg hover:bg-indigo-700 transition">Detailed</button>
                <button onclick="window.location.href='{{ route('timesheet.weeklyReport') }}'"
                    class="px-4 py-2 text-sm font-medium  bg-gray-200 hover:bg-gray-300 rounded-lg">Weekly</button>
                <button class="px-4 py-2 text-sm font-medium bg-gray-200 hover:bg-gray-300 rounded-lg">Shared</button>


                <input type="date" class="border p-2 rounded-lg shadow-md" value="2025-02-24">
                <input type="date" class="border p-2 rounded-lg shadow-md" value="2025-03-02">
                <button class="px-4 py-2 bg-indigo-700 text-white rounded-lg hover:bg-indigo-700 transition">Apply
                    Filter</button>
            </div>

            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Project</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Mo</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Tu</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">We</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Th</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Fr</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Sa</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Su</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-800 border-b">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-800">Attendance App</td>
                            <td class="px-6 py-4">10:00</td>
                            <td class="px-6 py-4">8:00</td>
                            <td class="px-6 py-4">9:00</td>
                            <td class="px-6 py-4">8:00</td>
                            <td class="px-6 py-4">8:00</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4 font-bold">43:00</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-800">JDM - Infinity Code</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4">0:45</td>
                            <td class="px-6 py-4">1:30</td>
                            <td class="px-6 py-4">2:00</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4 font-bold">4:15</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-800">Sisin Travels</td>
                            <td class="px-6 py-4">5:30</td>
                            <td class="px-6 py-4">4:30</td>
                            <td class="px-6 py-4">2:00</td>
                            <td class="px-6 py-4">3:30</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4 font-bold">15:30</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
