<x-app-layout>
    <div class="container mx-auto p-6">

        <div class="mt-1 mb-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Report Summary</h1>

            <button onclick="window.location.href='{{ route('timesheet.listView') }}'"
                class="px-4 py-2 text-sm font-medium text-white bg-indigo-700 rounded hover:bg-indigo-700 ">
                Back to Time Tracking
            </button>


        </div>

        <div class="mt-5 mb-4 flex space-x-2  items-center">


            <button onclick="window.location.href='{{ route('timesheet.chartsView') }}'"
                class="px-4 py-2 text-sm font-medium  bg-indigo-700 text-white rounded-lg hover:bg-indigo-700 transition">Summary</button>
            <button onclick="window.location.href='{{ route('timesheet.detailedReport') }}'"
                class="px-4 py-2 text-sm font-medium  bg-gray-200 hover:bg-gray-300 rounded-lg ">Detailed</button>
            <button onclick="window.location.href='{{ route('timesheet.weeklyReport') }}'"
                class="px-4 py-2 text-sm font-medium  bg-gray-200 hover:bg-gray-300 rounded-lg">Weekly</button>
            <button class="px-4 py-2 text-sm font-medium bg-gray-200 hover:bg-gray-300 rounded-lg">Shared</button>

        </div>



        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 ">
            <!-- Bar Chart -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-2">Hours Worked Per Day</h2>
                <canvas id="barChart"></canvas>
            </div>


            <!-- Pie Chart -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-2">Time Spent on Projects</h2>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
        <div class="mt-6 grid grid-cols-1 ">

            <!-- UI Section to view upcoming tasks-->
            <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center justify-center">
                <h2 class="text-lg font-semibold mb-2">Upcoming Tasks</h2>
                <ul class="list-disc text-gray-600">
                    <li>Complete Project A Report</li>
                    <li>Team Meeting - Wednesday</li>
                    <li>Submit Weekly Timesheet</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                datasets: [{
                    label: 'Hours Worked',
                    data: [5, 6, 4, 7, 8, 3, 2],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Project A', 'Project B', 'Project C', 'Project D'],
                datasets: [{
                    data: [10, 15, 25, 50],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    });
</script>
