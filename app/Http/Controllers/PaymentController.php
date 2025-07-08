<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Subscription;
use App\Models\ProjectSubscription;
use Stripe\Exception\ApiErrorException;
class PaymentController extends Controller
{

    public function index()
    {

        return view('pages.payments.index');
    }

      // to cancel subscription
    public function cancelSubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|string',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // to cancel the subscription in Stripe
            $stripeSubscription = Subscription::retrieve($request->subscription_id);
            $stripeSubscription->cancel();

            // to update local database record
            $subscription = ProjectSubscription::where('stripe_subscription_id', $request->subscription_id)->first();
            if ($subscription) {
                $subscription->update([
                    'status' => 'canceled',
                    'canceled_at' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Subscription has been canceled successfully.');
        } catch (ApiErrorException $e) {
            return redirect()->back()->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }
}
