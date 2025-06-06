<x-app-layout>
    <div class="container mx-auto my-10">

        <div class="
         flex justify-between">
            <div>
                <span>Invoice 71</span>
            </div>

            <div>
                <button @click="open = !open" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 12h.01M12 12h.01M18 12h.01" />
                    </svg>
                </button>
            </div>
        </div>

        <div>
            <hr>
        </div>

        <div class="        ">

            <div class="grid grid-cols-12">

                <div>
                    <div>status</div>
                    <span class="bg-gray-300 text-gray-700 rounded-lg py-2 px-4">Draft</span>
                </div>

                <div class="col-span-2">
                    <div>Customer</div>
                    <span class=" text-gray-700">The Idea Hub</span>
                </div>
                <div class="col-span-7">

                </div>

                <div class="">
                    <div>Due Date</div>
                    <span class="text-gray-700">06 Jun 2025</span>
                </div>
                <div class="">
                    <div>Due Amount</div>
                    <span class=" text-gray-700">LKR5,000.00

                    </span>
                </div>


            </div>
        </div>

        <div>
            <div class="bg-gray-200 max-w-4xl mx-auto p-5 grid grid-cols-1 gap-4">

                <div class="grid grid-cols-4 bg-white p-5">

                    <div class="flex  items-center justify-between">
                        <div>
                            <span class="border-[1px] border-orange-400 p-3 rounded-full"><i class="fa-regular fa-file-lines text-lg" style="color: #ff9500;"></i></span>
                        </div>
                        <div>
                            <div>Create</div>
                            <span>Created: 2025-06-06</span>
                        </div>
                    </div>

                    <div class="col-span-2">

                    </div>

                    <div class="flex  items-center justify-between">
                        <div>
                            <i class="fa-solid fa-money-check-pen"></i>
                            <span>Edit</span>
                        </div>

                        <div>
                            <button class="bg-orange-400 px-4 py-2">Approve draft</button>
                        </div>

                    </div>


                </div>

                <div class="grid grid-cols-4 bg-white p-5">

                    <div class="flex  items-center justify-between">
                        <div>
                            <span class="border-[1px] border-orange-400 p-3 rounded-full"><i class="fa-solid fa-paper-plane text-lg" style="color: #ff9500;"></i></span>
                        </div>
                        <div>
                            <div>Send</div>
                            <span>Last Sent: 2025-06-06</span>
                        </div>
                    </div>

                    <div class="col-span-1">

                    </div>

                    <div class="flex col-span-2 items-center justify-between">
                        <div>
                            <span>Mark as Sent</span>
                        </div>

                        <div>
                            <button class="bg-orange-400 px-4 py-2">Send Invoice</button>
                        </div>

                    </div>


                </div>

                <div class="grid grid-cols-4 bg-white p-5">

                    <div class="flex  items-center justify-between">
                        <div>
                            <span class="border-[1px] border-orange-400 p-3 rounded-full"><i class="fa-solid fa-money-check-dollar text-lg" style="color: #ff9500;"></i></span>
                        </div>
                        <div>
                            <div>Get paid</div>
                            <span>Amount due: LKR55000</span>
                        </div>
                    </div>

                    <div class="col-span-1">

                    </div>

                    <div class="flex col-span-2 items-center justify-between">
                        <div>
                            <span>Send a reminder</span>
                        </div>

                        <div>
                            <button class="bg-orange-400 px-4 py-2">Record payment</button>
                        </div>

                    </div>


                </div>


                <div class="grid grid-cols-4 bg-white p-5">

                    <div class="col-span-4 bg-white p-5">
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Invoice Preview</h3>
                        <div class="border rounded overflow-hidden shadow">
                            <iframe
                                src="{{ route('invoices.showPdf', ['invoice' => 3]) }}"
                                width="100%"
                                height="600px"
                                class="w-full border-none">
                            </iframe>
                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>
</x-app-layout>