<x-app-layout>

    <div class="flex h-full flex-col">
        <h1 class=" text-3xl font-bold text-gray-900">
            Timesheet
        </h1>
        <header class="flex flex-none items-center justify-between border-b border-gray-200 px-6 py-4">


            <h2 class="text-base font-semibold text-gray-900">
                <time datetime="2022-01">January 2022</time>
            </h2>


            <div class="flex items-center">


                <div class="relative flex items-center rounded-md bg-white shadow-xs md:items-stretch">
                    <!-- Previous Week Button -->
                    <button type="button"
                        class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50"
                        id="prev-button">
                        <span class="sr-only">Previous week</span>
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Today Button -->
                    <button id="today-button" type="button"
                        class="border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block">Select
                        the week

                    </button>
                    <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>

                    <!-- Next Week Button -->
                    <button type="button"
                        class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50"
                        id="next-button">
                        <span class="sr-only">Next week</span>
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>




                <!-- Dropdown for View Selection -->
                <div class="hidden md:ml-4 md:flex md:items-center">
                    <div class="relative">
                        <button type="button"
                            class="flex items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50"
                            id="view-menu-button" aria-expanded="false" aria-haspopup="true">
                            Select the view
                            <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 z-10 mt-3 w-36 origin-top-right overflow-hidden rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden hidden"
                            role="menu" aria-orientation="vertical" aria-labelledby="view-menu-button" tabindex="-1"
                            id="dropdown-view-menu">
                            <div class="py-1" role="none">
                                <a href="{{ route('timesheet.calendarView') }}"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-calendar-view">Calendar</a>
                                <a href="{{ route('timesheet.listView') }}"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-list-view">List View</a>

                            </div>
                        </div>
                    </div>

                    <div class="ml-6 h-6 w-px bg-gray-300"></div>
                    <button type="button"
                        class="ml-6 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Select
                        a Project</button>
                </div>
            </div>
        </header>


        <div class="isolate flex flex-auto flex-col overflow-auto bg-white">
            <div style="width: 165%" class="flex max-w-full flex-none flex-col sm:max-w-none md:max-w-full">
                <div class="sticky top-0 z-30 flex-none bg-white ring-1 shadow-sm ring-black/5 sm:pr-8">
                    <div class="grid grid-cols-7 text-sm/6 text-gray-500 sm:hidden">
                        <button type="button" class="flex flex-col items-center pt-2 pb-3">M <span
                                class="mt-1 flex size-8 items-center justify-center font-semibold text-gray-900">10</span></button>
                        <button type="button" class="flex flex-col items-center pt-2 pb-3">T <span
                                class="mt-1 flex size-8 items-center justify-center font-semibold text-gray-900">11</span></button>
                        <button type="button" class="flex flex-col items-center pt-2 pb-3">W <span
                                class="mt-1 flex size-8 items-center justify-center rounded-full bg-indigo-600 font-semibold text-white">12</span></button>
                        <button type="button" class="flex flex-col items-center pt-2 pb-3">T <span
                                class="mt-1 flex size-8 items-center justify-center font-semibold text-gray-900">13</span></button>
                        <button type="button" class="flex flex-col items-center pt-2 pb-3">F <span
                                class="mt-1 flex size-8 items-center justify-center font-semibold text-gray-900">14</span></button>
                        <button type="button" class="flex flex-col items-center pt-2 pb-3">S <span
                                class="mt-1 flex size-8 items-center justify-center font-semibold text-gray-900">15</span></button>
                        <button type="button" class="flex flex-col items-center pt-2 pb-3">S <span
                                class="mt-1 flex size-8 items-center justify-center font-semibold text-gray-900">16</span></button>
                    </div>

                    <div
                        class="-mr-px hidden grid-cols-7 divide-x divide-gray-100 border-r border-gray-100 text-sm/6 text-gray-500 sm:grid">
                        <div class="col-end-1 w-14"></div>
                        <div class="flex items-center justify-center py-3">
                            <span>Mon <span
                                    class="items-center justify-center font-semibold text-gray-900">10</span></span>
                        </div>
                        <div class="flex items-center justify-center py-3">
                            <span>Tue <span
                                    class="items-center justify-center font-semibold text-gray-900">11</span></span>
                        </div>
                        <div class="flex items-center justify-center py-3">
                            <span class="flex items-baseline">Wed <span
                                    class="ml-1.5 flex size-8 items-center justify-center rounded-full bg-indigo-600 font-semibold text-white">12</span></span>
                        </div>
                        <div class="flex items-center justify-center py-3">
                            <span>Thu <span
                                    class="items-center justify-center font-semibold text-gray-900">13</span></span>
                        </div>
                        <div class="flex items-center justify-center py-3">
                            <span>Fri <span
                                    class="items-center justify-center font-semibold text-gray-900">14</span></span>
                        </div>
                        <div class="flex items-center justify-center py-3">
                            <span>Sat <span
                                    class="items-center justify-center font-semibold text-gray-900">15</span></span>
                        </div>
                        <div class="flex items-center justify-center py-3">
                            <span>Sun <span
                                    class="items-center justify-center font-semibold text-gray-900">16</span></span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-auto">
                    <div class="sticky left-0 z-10 w-14 flex-none bg-white ring-1 ring-gray-100"></div>
                    <div class="grid flex-auto grid-cols-1 grid-rows-1">
                        <!-- Horizontal lines -->
                        <div class="col-start-1 col-end-2 row-start-1 grid divide-y divide-gray-100"
                            style="grid-template-rows: repeat(48, minmax(3.5rem, 1fr))">
                            <div class="row-end-1 h-7"></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    12AM</div>
                            </div>
                            <div>
                            </div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    1AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    2AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    3AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    4AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    5AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    6AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    7AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    8AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    9AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    10AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    11AM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    12PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    1PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    2PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    3PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    4PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    5PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    6PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    7PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    8PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    9PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    10PM</div>
                            </div>
                            <div></div>
                            <div>
                                <div
                                    class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400">
                                    11PM</div>
                            </div>
                            <div></div>
                        </div>

                        <!-- Vertical lines -->
                        <div
                            class="col-start-1 col-end-2 row-start-1 hidden grid-cols-7 grid-rows-1 divide-x divide-gray-100 sm:grid sm:grid-cols-7">
                            <div class="col-start-1 row-span-full">


                            </div>
                            <div class="col-start-2 row-span-full"></div>
                            <div class="col-start-3 row-span-full"></div>
                            <div class="col-start-4 row-span-full"></div>
                            <div class="col-start-5 row-span-full"></div>
                            <div class="col-start-6 row-span-full"></div>
                            <div class="col-start-7 row-span-full"></div>
                            <div class="col-start-8 row-span-full w-8"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    //To handle content switching dynamically
    const viewMenuButton = document.getElementById("view-menu-button");
    const dropdownViewMenu = document.getElementById("dropdown-view-menu");

    // Toggle View Options Dropdown
    viewMenuButton.addEventListener("click", () => {
        dropdownViewMenu.classList.toggle("hidden");
    });

    // Handle View Options Selection
    document.getElementById("menu-calendar-view").addEventListener("click", () => {
        calendarView.innerHTML = "This is the Calendar view content.";
        dropdownViewMenu.classList.add("hidden");
    });

    document.getElementById("menu-list-view").addEventListener("click", () => {
        calendarView.innerHTML = "This is the List view content.";
        dropdownViewMenu.classList.add("hidden");
    });


    // Close dropdown when clicking outside
    document.addEventListener("click", (event) => {
        if (!dropdownViewMenu.contains(event.target) && !viewMenuButton.contains(event.target)) {
            dropdownViewMenu.classList.add("hidden");
        }
    });
</script>
