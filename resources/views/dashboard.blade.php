<x-app-layout>
    <div class="flex-1 ml-64">
        <div class=" flex h-screen overflow-hidden">
            <!-- Main Content -->
            <div class=" w-3/4 mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">

                <h2 class=" font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Timesheet') }}
                </h2>

                <!-- Header Section -->
                <div class="flex items-center justify-between mb-4">
                    <button id="prevWeek" class="px-3 py-2 bg-gray-200 rounded">&larr;</button>
                    <h3 class="text-lg font-semibold">This week: <span id="weekRange"></span></h3>
                    <button id="nextWeek" class="px-3 py-2 bg-gray-200 rounded">&rarr;</button>
                    <div>
                        <button id="dayView" class="px-3 py-2 border rounded">Day</button>
                        <button id="weekView" class="px-3 py-2 border rounded bg-orange-500 text-white">Week</button>
                    </div>
                </div>

                <!-- Timesheet Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200" id="timesheetTable">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">Project / Task</th>
                                <th class="px-4 py-2 border">Mon</th>
                                <th class="px-4 py-2 border">Tue</th>
                                <th class="px-4 py-2 border">Wed</th>
                                <th class="px-4 py-2 border">Thu</th>
                                <th class="px-4 py-2 border">Fri</th>
                                <th class="px-4 py-2 border">Sat</th>
                                <th class="px-4 py-2 border">Sun</th>
                                <th class="px-4 py-2 border">Total</th>
                                <th class="px-4 py-2 border"></th>
                            </tr>
                        </thead>
                        <tbody id="timesheetBody">
                            <!-- Rows will be added dynamically -->
                        </tbody>
                        <tfoot>
                            <tr class="border-t font-semibold">
                                <td class="px-4 py-2">Total</td>
                                <td class="px-4 py-2 text-center" id="totalMon">0</td>
                                <td class="px-4 py-2 text-center" id="totalTue">0</td>
                                <td class="px-4 py-2 text-center" id="totalWed">0</td>
                                <td class="px-4 py-2 text-center" id="totalThu">0</td>
                                <td class="px-4 py-2 text-center" id="totalFri">0</td>
                                <td class="px-4 py-2 text-center" id="totalSat">0</td>
                                <td class="px-4 py-2 text-center" id="totalSun">0</td>
                                <td class="px-4 py-2 text-center" id="grandTotal">0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-4 mt-4">
                    <button id="addRow" class="px-4 py-2 bg-gray-200 rounded">+ Add row</button>
                    <button id="saveButton" class="px-4 py-2 bg-green-500 text-white rounded">Save</button>
                </div>
                <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Submit week for approval</button>
            </div>

            <!-- JavaScript for Functionality -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const weekRange = document.getElementById("weekRange");
                    const timesheetBody = document.getElementById("timesheetBody");

                    let currentWeekStart = new Date();
                    currentWeekStart.setDate(currentWeekStart.getDate() - currentWeekStart.getDay() + 1); // Set to Monday

                    function updateWeek() {
                        let start = new Date(currentWeekStart);
                        let end = new Date(start);
                        end.setDate(end.getDate() + 6);

                        weekRange.textContent = formatDate(start) + " - " + formatDate(end);
                    }

                    function formatDate(date) {
                        return date.toLocaleDateString('en-GB', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        });
                    }

                    function prevWeek() {
                        currentWeekStart.setDate(currentWeekStart.getDate() - 7);
                        updateWeek();
                    }

                    function nextWeek() {
                        currentWeekStart.setDate(currentWeekStart.getDate() + 7);
                        updateWeek();
                    }

                    function addRow() {
                        let row = document.createElement("tr");
                        row.innerHTML = `
                    <td class="px-4 py-2">
                        <input type="text" class="w-full border p-2 text-center" placeholder="Project Name">
                        <input type="text" class="w-full border p-2 text-center" placeholder="Task Name">
                    </td>
                    ${Array(7).fill().map(() => `<td class="px-4 py-2"><input type="text" class="w-full border p-2 text-center time-entry"></td>`).join('')}
                    <td class="px-4 py-2 text-center total-hours">0</td>
                    <td class="px-4 py-2 text-center"><button class="text-red-500 removeRow">✖</button></td>
                `;

                        timesheetBody.appendChild(row);
                        attachEventListeners();
                    }

                    function attachEventListeners() {
                        document.querySelectorAll(".time-entry").forEach(input => {
                            input.addEventListener("input", updateTotals);
                        });

                        document.querySelectorAll(".removeRow").forEach(button => {
                            button.addEventListener("click", function() {
                                this.closest("tr").remove();
                                updateTotals();
                            });
                        });
                    }

                    function updateTotals() {
                        let totals = Array(7).fill(0);
                        let grandTotal = 0;

                        document.querySelectorAll("#timesheetBody tr").forEach(row => {
                            let total = 0;
                            row.querySelectorAll(".time-entry").forEach((input, i) => {
                                let val = parseFloat(input.value) || 0;
                                totals[i] += val;
                                total += val;
                            });

                            row.querySelector(".total-hours").textContent = total;
                            grandTotal += total;
                        });

                        document.getElementById("totalMon").textContent = totals[0];
                        document.getElementById("totalTue").textContent = totals[1];
                        document.getElementById("totalWed").textContent = totals[2];
                        document.getElementById("totalThu").textContent = totals[3];
                        document.getElementById("totalFri").textContent = totals[4];
                        document.getElementById("totalSat").textContent = totals[5];
                        document.getElementById("totalSun").textContent = totals[6];
                        document.getElementById("grandTotal").textContent = grandTotal;
                    }

                    document.getElementById("addRow").addEventListener("click", addRow);
                    document.getElementById("prevWeek").addEventListener("click", prevWeek);
                    document.getElementById("nextWeek").addEventListener("click", nextWeek);

                    updateWeek();
                });
            </script>
        </div>
    </div>
</x-app-layout>
