<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-6">Card Payment Setup</h2>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form id="payment-form">
            @csrf

            <!-- Client and Project Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Client</label>
                    <select name="client_id" id="client_id" class="w-full p-2 border rounded" required>
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Project</label>
                    <select name="project_id" id="project_id" class="w-full p-2 border rounded" required disabled>
                        <option value="">Select Client First</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount (AUD)</label>
                    <input type="number" name="amount" id="amount" class="w-full p-2 border rounded" step="0.01"
                        min="1" required>
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

            <!-- Card Details Section -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Card Details</label>
                <div id="card-element" class="p-3 border rounded-lg"></div>
                <div id="card-errors" class="text-red-500 text-sm mt-1"></div>
            </div>

            <input type="hidden" name="payment_method_id" id="payment_method_id">

            <button type="submit" id="submit-button"
                class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Process Payment
            </button>
        </form>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        // Client change
        document.getElementById('client_id').addEventListener('change', function() {
            const clientId = this.value;
            const projectSelect = document.getElementById('project_id');

            if (!clientId) {
                projectSelect.innerHTML = '<option value="">Select Client First</option>';
                projectSelect.disabled = true;
                return;
            }

            // Fetch projects for selected client
            fetch(`/payments/projects/${clientId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
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

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');

        // Handle real-time validation errors
        card.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Validate all fields
            const clientId = document.getElementById('client_id').value;
            const projectId = document.getElementById('project_id').value;
            const amount = document.getElementById('amount').value;

            if (!clientId || !projectId || !amount) {
                alert('Please fill all required fields');
                return;
            }

            submitButton.disabled = true;

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                submitButton.disabled = false;
            } else {
                document.getElementById('payment_method_id').value = paymentMethod.id;


                const confirmForm = document.createElement('form');
                confirmForm.method = 'POST';
                confirmForm.action = "{{ route('payments.card-confirm') }}";

                const formData = new FormData(form);
                for (const [name, value] of formData.entries()) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = name;
                    input.value = value;
                    confirmForm.appendChild(input);
                }

                // Add CSRF token
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('input[name="_token"]').value;
                confirmForm.appendChild(csrf);

                document.body.appendChild(confirmForm);
                confirmForm.submit();
            }
        });
    </script>
</x-app-layout>
