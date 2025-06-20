<x-app-layout>
<div class="max-w-4xl mx-auto px-4 py-8">
  <div class="bg-white rounded-lg shadow-md overflow-hidden">

            <div class="bg-blue-700 px-6 py-4 ">
             <h2 class="text-xl font-semibold text-white flex items-center">
                     <svg class="w-8 h-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>Setup Project Subscription</h2>
        </div>

            <div class="p-6">
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

    <form action="{{ route('project-payment.setupBecs') }}" method="POST">
       @csrf

                  <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class=" text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Select Client
                                </label>
                <select name="client_id" id="client_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class=" text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                            clip-rule="evenodd" />
                                    </svg>Select Project</label>
                <select name="project_id" id="project_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required disabled>
                    <option value="">Select a Client first</option>
                </select>
            </div>

                      </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">BSB</label>
                <input type="text" name="bsb" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="123456" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                <input type="text" name="account_number" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                       </div>
            </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount (AUD)</label>
                <input type="number" name="amount" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" step="0.01" min="1" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Cycle</label>
                <select name="payment_cycle" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="weekly">Weekly</option>
                    <option value="monthly" selected>Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Authorize BECS Direct Debit
            </button>
                 </div>
        </div>
    </form>
            </div>
        </div>
</div>
<script>
    document.getElementById('client_id').addEventListener('change', function() {
        const clientId = this.value;
        const projectSelect = document.getElementById('project_id');

        if (!clientId) {
            projectSelect.innerHTML = '<option value="">Select a Client first</option>';
            projectSelect.disabled = true;
            return;
        }

        fetch(`/project-payment/projects/${clientId}`)
            .then(response => response.json())
            .then(projects => {
                let options = '<option value="">Select Project</option>';

                if (projects.length > 0) {
                    projects.forEach(project => {
                        options += `<option value="${project.id}">${project.name}</option>`;
                    });
                    projectSelect.disabled = false;
                } else {
                    options = '<option value="">No projects found for this client</option>';
                    projectSelect.disabled = true;
                }

                projectSelect.innerHTML = options;
            })
            .catch(error => {
                console.error('Error fetching projects:', error);
                projectSelect.innerHTML = '<option value="">Error loading projects</option>';
            });
    });
</script>
</x-app-layout>
