<x-app-layout>

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6">Setup Project Subscription</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('project-payment.setupBecs') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Client</label>
                <select name="client_id" id="client_id" class="w-full p-2 border rounded" required>
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Project</label>
                <select name="project_id" id="project_id" class="w-full p-2 border rounded" required disabled>
                    <option value="">Select a Client first</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">BSB</label>
                <input type="text" name="bsb" class="w-full p-2 border rounded" placeholder="123456" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                <input type="text" name="account_number" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount (AUD)</label>
                <input type="number" name="amount" class="w-full p-2 border rounded" step="0.01" min="1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Cycle</label>
                <select name="payment_cycle" class="w-full p-2 border rounded" required>
                    <option value="weekly">Weekly</option>
                    <option value="monthly" selected>Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Authorize BECS Direct Debit
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('client_id').addEventListener('change', function() {
        const clientId = this.value;
        const projectSelect = document.getElementById('project_id');

        if (!clientId) {
            projectSelect.innerHTML = '<option value="">Select a Client first </option>';
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
