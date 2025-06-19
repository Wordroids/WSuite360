<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectSubscription;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\SetupIntent;
use Stripe\Price;
use Stripe\Product;
use Stripe\Subscription;
use Stripe\PaymentMethod;
use Carbon\Carbon;

class ProjectPaymentController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        $projects = Project::all();

        return view('pages.payments.bankCharge', compact('clients', 'projects'));
    }
    public function getProjects($clientId)
    {
        $projects = Project::where('client_id', $clientId)->get();
        return response()->json($projects);
    }

    public function setupBecs(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'required|exists:projects,id',
            'bsb' => 'required',
            'account_number' => 'required',
            'payment_cycle' => 'required|in:weekly,monthly,yearly',
            'amount' => 'required|numeric',
        ]);
        $project = Project::findOrFail($request->project_id);

        // Check if project has been started
        if ($project->start_date && Carbon::parse($project->start_date)->isFuture()) {
            return redirect()->back()->with('error', "Can't process the payment. The selected project has not been started yet.");
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $client = Client::findOrFail($request->client_id);


        if (!$client->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $client->email,
                'name' => $client->name,
            ]);
            $client->update(['stripe_customer_id' => $customer->id]);
        }

        $intent = SetupIntent::create([
            'customer' => $client->stripe_customer_id,
            'payment_method_types' => ['au_becs_debit'],
        ]);

        return view('pages.payments.confirm', [
            'client_secret' => $intent->client_secret,
            'client' => $client,
            'project' => $project,
            'bsb' => $request->bsb,
            'account_number' => $request->account_number,
            'payment_cycle' => $request->payment_cycle,
            'amount' => $request->amount,
        ]);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'payment_cycle' => 'required|in:weekly,monthly,yearly',
            'amount' => 'required|numeric',
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $client = Client::findOrFail($request->client_id);
        $project = Project::findOrFail($request->project_id);

        $paymentMethod = $request->payment_method;

        PaymentMethod::retrieve($paymentMethod)->attach(['customer' => $client->stripe_customer_id]);

        Customer::update($client->stripe_customer_id, [
            'invoice_settings' => ['default_payment_method' => $paymentMethod],
        ]);

        $interval = $this->getSubscriptionInterval($request->payment_cycle);

        $product = Product::create([
            'name' => "Subscription for Project: {$project->name}",
            'type' => 'service'
        ]);

        $plan = Price::create([
            'product' => $product->id,
            'currency' => 'aud',
            'recurring' => ['interval' => $interval['interval'], 'interval_count' => 1],
            'unit_amount' => $request->amount * 100,
        ]);

        $subscription = Subscription::create([
            'customer' => $client->stripe_customer_id,
            'items' => [['price' => $plan->id]],
            'default_payment_method' => $paymentMethod,
            'expand' => ['latest_invoice.payment_intent'],
        ]);

        ProjectSubscription::create([
            'client_id' => $client->id,
            'project_id' => $project->id,
            'stripe_subscription_id' => $subscription->id,
            'status' => $subscription->status,
            'amount' => $request->amount,
            'currency' => $subscription->currency,
            'billing_cycle' => $subscription->plan->interval
        ]);

        return redirect()->route('projects.index')->with('success', 'Subscription created successfully!');
    }

    private function getSubscriptionInterval($cycle)
    {
        switch ($cycle) {
            case 'weekly':
                return ['interval' => 'week'];
            case 'monthly':
                return ['interval' => 'month'];
            case 'yearly':
                return ['interval' => 'year'];
            default:
                return ['interval' => 'month'];
        }
    }
}
