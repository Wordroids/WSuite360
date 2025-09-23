<?php

namespace Modules\Subscriptions\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\ProjectSubscription as AppModelsProjectSubscription;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Subscription;

use Stripe\Exception\ApiErrorException;

use Modules\Subscriptions\Models\ProjectSubscription;

class PaymentController extends Controller
{

    public function index()
    {

        return view('subscriptions::pages.payments.index');
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
