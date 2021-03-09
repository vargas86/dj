<?php

namespace App\Actions\Web\Member\Profile\Subscriptions;

use App\Models\Channel;
use App\Models\Subscription;
use Exception;
use Lorisleiva\Actions\Action;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

class Reactivate extends Action
{
    /**
     * Determine if the user is authorized to make this action.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the action.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle($channel)
    {
        try {
            $channel = Channel::find($channel);
            if (!$channel) abort(404);
            $sub = Subscription::where('channel_id', $channel->id)->where('subscriber_id', \Auth::user()->id)->first();
            if (strtotime($sub->end) > strtotime('now')) {
                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                $stripe_sub = StripeSubscription::update($sub->subscription_stripe_id, [
                    'cancel_at_period_end' => false,
                ]);
                $sub->actif = true;
                $sub->end = null;
                $sub->save();
                return redirect(route('profile.subscriptions'));
            }
            return redirect(route('subscribe', ['channel' => $channel->id]));
        } catch (Exception $e) {
            return redirect(route('profile.subscriptions'));
        }
    }
}
