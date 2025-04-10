<!-- Static sidebar for desktop -->
<div class="inset-y-0 z-50 w-72 flex-col">
    <div class="flex h-screen flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-4">
        <div class="flex h-16 shrink-0 items-center">
            <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=white"
                alt="Your Company">
        </div>
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="group flex gap-x-3 rounded-md bg-indigo-700 p-2 text-sm/6 font-semibold text-white">
                                <svg class="size-6 shrink-0 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('companies.index') }}"
                                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <svg class="size-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                    data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                Companies
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projects.index') }}"
                                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <svg class="size-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                    data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg>
                                Projects
                            </a>

                        </li>
                        <li>
                            <a href="{{ route('clients.index') }}"
                                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <svg class="size-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                    data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                Clients
                            </a>
                        </li>



                        <li>
                            <a href="{{ route('tasks.index') }}"
                                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <svg class="size-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                    data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                </svg>
                                Tasks
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('timesheet.calendarView') }}"
                                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <svg class="size-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                    data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                </svg>
                                Timesheet
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="text-xs/6 font-semibold text-indigo-200">Your teams</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li>

                            <a href="#"
                                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <span
                                    class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">H</span>
                                <span class="truncate">Project Members</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('invoice.index') }}"
                                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <span
                                    class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">H</span>
                                <span class="truncate">Invoice</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('pages.activity_log.logs') }}"
                                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <span
                                    class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">T</span>
                                <span class="truncate">Activity Log</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pages.time_entry_approval.index') }}"
                                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <span
                                    class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">W</span>
                                <span class="truncate">Time Entry Approval</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="mt-auto">

                    <!-- Profile Section -->
                    <div
                        class="  group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
                        <button type="button" class="flex items-center space-x-2 text-indigo-200"
                            onclick="toggleDropdown()">
                            <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdown-menu"
                            class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100">Your profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-900 hover:bg-gray-100">Log
                                    out</button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById("dropdown-menu");
        dropdown.classList.toggle("hidden");
    }

    //Not working
    // Get the sidebar and close button
    const sidebar = document.getElementById('sidebar');
    const closeButton = document.querySelector('.close-sidebar');

    // Function to toggle the sidebar
    closeButton.addEventListener('click', function() {
        sidebar.classList.toggle('hidden'); // Toggle hidden class to show/hide sidebar
    });
</script>
