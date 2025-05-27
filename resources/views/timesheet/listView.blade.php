<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Time Tracking</h1>

        <!-- Navigation Buttons -->
              <button onclick="window.location.href='{{ route('timesheet.listView') }}'"
            class="px-4 py-2 text-sm font-medium  bg-indigo-700 text-white rounded-lg hover:bg-indigo-700 transition">
            List View
        </button>

        <button onclick="window.location.href='{{ route('timesheet.chartsView') }}'"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            View Charts
        </button>

        <!-- Time Entry -->
        <div class="flex justify-between items-center mt-4 mb-6">
            <input type="text" id="taskInput" placeholder="What are you working on?"
                class="w-2/3 bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

            <select id="project_id" name="project_id"
                class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Project</option>
                @if (!empty($projects) && is_array($projects))
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                @else
                    <option value="1">Dummy Project 1</option>
                    <option value="2">Dummy Project 2</option>
                @endif
            </select>

            <div class="flex items-center space-x-2">
                <button id="startStopBtn" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-blue-600">
                    START
                </button>
                <span id="timerDisplay" class="text-lg font-mono">00:00:00</span>
            </div>
        </div>

        <!-- Week Summary -->
        <div class="bg-gray-100 px-4 py-2 rounded-lg font-semibold text-gray-700 mb-4 flex justify-between items-center">
            <span>This week</span>
            <span class="text-indigo-600">Week total: 24:00</span>
        </div>

        <!-- Timesheet Entries -->

<!-- Entry 1 (dummy data)-->
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

        @foreach ($timeLogs as $log)
            <div class="bg-white shadow rounded-lg p-4 mb-2">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-2">
                    <span class="text-gray-500 text-sm">{{ $log->date->format('D, M d') }}</span>
                    <span class="text-gray-700 font-bold">Total: {{ gmdate("H:i", $log->time_spent * 60) }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-700">{{ $log->task->name }}</span>
                        <span class="text-gray-500 text-sm">● {{ $log->project->name }}</span>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-gray-500 text-sm">{{ $log->start_time }} - {{ $log->end_time }}</span>
                        <span class="font-semibold text-gray-700">{{ gmdate("H:i", $log->time_spent * 60) }}</span>

                        <!-- Three Dots Menu -->
                        <div style="position: relative;">
                            <span style="cursor: pointer; font-size: 20px;" onclick="toggleMenu(this)">⋮</span>
                            <div class="menu hidden"
                                style="position: absolute; right: 0; background: white; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                                <ul style="list-style: none; margin: 0; padding: 10px;">
                                    <li style="padding: 5px; cursor: pointer;"
                                        onclick="window.location.href='{{ route('timesheet.view', $log->id) }}'">View</li>
                                    <li style="padding: 5px; cursor: pointer;"
                                        onclick="window.location.href='{{ route('timesheet.edit', $log->id) }}'">Edit</li>
                                    <li style="padding: 5px; cursor: pointer;" onclick="deleteTask({{ $log->id }})">Delete</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>

<script>
    let timer;
    let seconds = 0;
    let isRunning = false;

    function toggleMenu(element) {
        const menu = element.nextElementSibling;
        menu.classList.toggle('hidden');
    }

    function deleteTask(id) {
        if (confirm('Are you sure you want to delete this task?')) {
            window.location.href = '/timesheet/delete/' + id;
        }
    }

    function updateTimerDisplay() {
        let hrs = Math.floor(seconds / 3600);
        let mins = Math.floor((seconds % 3600) / 60);
        let secs = seconds % 60;

        document.getElementById('timerDisplay').textContent =
            String(hrs).padStart(2, '0') + ":" +
            String(mins).padStart(2, '0') + ":" +
            String(secs).padStart(2, '0');
    }

    function startStopTimer() {
        const button = document.getElementById('startStopBtn');

        if (!isRunning) {
            button.textContent = 'STOP';
            button.classList.remove('bg-indigo-600');
            button.classList.add('bg-red-600');

            timer = setInterval(() => {
                seconds++;
                updateTimerDisplay();
            }, 1000);

            isRunning = true;
        } else {
            clearInterval(timer);
            button.textContent = 'START';
            button.classList.remove('bg-red-600');
            button.classList.add('bg-indigo-600');

            isRunning = false;
        }
    }

    document.getElementById('startStopBtn').addEventListener('click', startStopTimer);
</script>
