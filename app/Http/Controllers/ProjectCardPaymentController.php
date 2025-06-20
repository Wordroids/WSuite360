<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectSubscription;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Product;
use Stripe\Price;
use Stripe\Subscription;
use Carbon\Carbon;

class ProjectCardPaymentController extends Controller
{

    //to select the card
    public function selectCard()
    {
        $clients = Client::all();
        $projects = collect();
        return view('pages.payments.cardCharge', compact('clients', 'projects'));
    }

    //to get the project
    public function getProjects($clientId)
    {
        $projects = Project::where('client_id', $clientId)->get();
        return response()->json($projects);
    }

    //confirm payment
    public function confirm(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:1',
            'payment_cycle' => 'required|in:weekly,monthly,yearly',
            'payment_method_id' => 'required|string',
        ]);

        $project = Project::findOrFail($request->project_id);
        $client = Client::findOrFail($request->client_id);


        // Check if project has been started
        if ($project->start_date && Carbon::parse($project->start_date)->isFuture()) {
            return redirect()->back()->with('error', "Can't process the payment. The selected project has not been started yet.");
        }


        return view('pages.payments.cardConfirm', [
            'client' => $client,
            'project' => $project,
            'amount' => $request->amount,
            'payment_cycle' => $request->payment_cycle,
            'payment_method_id' => $request->payment_method_id,
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:1',
            'payment_cycle' => 'required|in:weekly,monthly,yearly',
            'payment_method_id' => 'required|string',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $project = Project::findOrFail($request->project_id);
        $client = Client::findOrFail($request->client_id);

        // Create or retrieve customer
        if (!$client->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $client->email,
                'name' => $client->name,
            ]);
            $client->update(['stripe_customer_id' => $customer->id]);
        }


        PaymentMethod::retrieve($request->payment_method_id)
            ->attach(['customer' => $client->stripe_customer_id]);

        Customer::update($client->stripe_customer_id, [
            'invoice_settings' => ['default_payment_method' => $request->payment_method_id],
        ]);


        $interval = $this->getSubscriptionInterval($request->payment_cycle);


        $product = Product::create([
            'name' => "Subscription for {$project->name}",
            'type' => 'service'
        ]);

        $price = Price::create([
            'product' => $product->id,
            'currency' => 'aud',
            'unit_amount' => $request->amount * 100,
            'recurring' => [
                'interval' => $interval['interval'],
                'interval_count' => 1
            ],
        ]);


        $subscription = Subscription::create([
            'customer' => $client->stripe_customer_id,
            'items' => [['price' => $price->id]],
            'default_payment_method' => $request->payment_method_id,
        ]);


        ProjectSubscription::create([
            'client_id' => $client->id,
            'project_id' => $project->id,
            'stripe_subscription_id' => $subscription->id,
            'status' => $subscription->status,
            'amount' => $request->amount,
            'currency' => $subscription->currency,
            'billing_cycle' => $subscription->plan->interval ?? $interval['interval'],
            'payment_type' => 'card',
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Card payment subscription created successfully!');
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
