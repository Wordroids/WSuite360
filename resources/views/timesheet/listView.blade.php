<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">List View</h1>

        <button onclick="window.location.href='{{ route('timesheet.calendarView') }}'"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            Calendar
        </button>

        <button onclick="window.location.href='{{ route('timesheet.listView') }}'"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            List View
        </button>

        <!-- Header -->
        <div class="flex justify-between items-center mt-4 mb-6">
            <input type="text" placeholder="What are you working on?"
                class="w-2/3 bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <div class="flex items-center space-x-2">
                <button class= "bg-indigo-600 text-white px-4 py-2 rounded hover:bg-blue-600">+ Project</button>
                <span class="text-lg font-mono">00:00:00</span>
                <button class=" bg-indigo-600 text-white px-4 py-2 rounded hover:bg-blue-600">START</button>
            </div>
        </div>

        <!-- Week Summary -->
        <div
            class="bg-gray-100 px-4 py-2 rounded-lg font-semibold text-gray-700 mb-4 flex justify-between items-center">
            <span>This week</span>
            <span class="text-indigo-600">Week total: 24:00</span>
        </div>

        <!-- Timesheet Entries -->

        <!-- Entry 1 -->
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-2">
                <span class="text-gray-500 text-sm">Fri, Mar 21</span>
                <span class="text-gray-700 font-bold">Total: 7:00</span>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex flex-col">
                    <span class="font-semibold text-gray-700">List View of the Timesheet</span>
                    <span class="text-gray-500 text-sm">● Wsuite360</span>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Calendar Toggle -->
                    <span style="cursor: pointer; margin-right: 10px;" onclick="showCalendar(this)">🗓️</span>
                    <span class="text-gray-500 text-sm">09:00 - 16:00</span>
                    <span class="font-semibold text-gray-700">7:00</span>

                    <!-- Calendar Container -->
                    <div class="calendar-container hidden"></div>

                    <!-- Three Dots Menu -->
                    <div style="position: relative; display: inline-block;">
                        <span style="cursor: pointer; font-size: 20px;" onclick="toggleMenu(this)">⋮</span>
                        <div class="menu hidden"
                            style="position: absolute; right: 0; background: white; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                            <ul style="list-style: none; margin: 0; padding: 10px;">
                                <li style="padding: 5px; cursor: pointer;"
                                    onclick="window.location.href='{{ route('timesheet.view') }}'">View</li>

                                <li style="padding: 5px; cursor: pointer;"
                                    onclick="window.location.href='{{ route('timesheet.edit') }}'">Edit</li>

                                <li style="padding: 5px; cursor: pointer;" onclick="deleteTask()">Delete</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function toggleMenu(element) {
        const menu = element.nextElementSibling;
        menu.classList.toggle('hidden');
    }

    function editTask() {
        alert('Edit task functionality');
    }

    function deleteTask() {
        alert('Delete task functionality');
    }
</script>
