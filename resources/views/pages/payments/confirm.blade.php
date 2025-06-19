<x-app-layout>
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-semibold mb-4">Confirm Direct Debit</h2>

    <form action="{{ route('project-payment.process') }}" id="confirmform" method="POST">
        @csrf
        <input type="hidden" name="payment_method" id="payment_method">
        <input type="hidden" name="payment_cycle" value="{{ $payment_cycle }}">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="client_id" value="{{ $client->id }}">
        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <div class="space-y-4">
            <div>
                <p class="font-medium">Client:</p>
                <p>{{ $client->name }} ({{ $client->email }})</p>
            </div>

            <div>
                <p class="font-medium">Project:</p>
                <p>{{ $project->name }}</p>
            </div>

            <div>
                <p class="font-medium">BSB:</p>
                <p>{{ $bsb }}</p>
            </div>

            <div>
                <p class="font-medium">Account Number:</p>
                <p>****{{ substr($account_number, -4) }}</p>
            </div>

            <div>
                <p class="font-medium">Amount:</p>
                <p>${{ number_format($amount, 2) }} AUD</p>
            </div>

            <div>
                <p class="font-medium">Payment Cycle:</p>
                <p>{{ ucfirst($payment_cycle) }}</p>
            </div>
        </div>

        <button type="button" id="confirmButton" class="mt-6 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
            Confirm Payment
        </button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.getElementById("confirmButton").addEventListener("click", async function() {
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const form = document.getElementById("confirmform");

        try {
            const { setupIntent, error } = await stripe.confirmAuBecsDebitSetup(
                "{{ $client_secret }}",
                {
                    payment_method: {
                        au_becs_debit: {
                            bsb_number: "{{ $bsb }}",
                            account_number: "{{ $account_number }}"
                        },
                        billing_details: {
                            name: "{{ $client->name }}",
                            email: "{{ $client->email }}"
                        }
                    }
                }
            );

            if (error) {
                alert(error.message);
                console.error("Stripe Error:", error);
                return;
            }

            document.getElementById("payment_method").value = setupIntent.payment_method;
            form.submit();
        } catch (e) {
            console.error("Error:", e);
            alert("An error occurred. Please try again.");
        }
    });
</script>
</x-app-layout>
