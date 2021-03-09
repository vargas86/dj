<?php

namespace App\Actions\Web\Member\Profile\Subscriptions;

use App\Models\Channel;
use App\Models\Subscription;
use Exception;
use App\Mail\Subscriptions\NewSubscriptionStudent;
use App\Mail\Subscriptions\NewSubscriptionTeacher;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Action;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

class Create extends Action
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
    public function handle()
    {
        try {
            $pack_id = request()->input('pack_id');
            $channel_id = request()->input('channel_id');

            $subscription = Subscription::where('subscriber_id', \Auth::user()->id)->where('channel_id', $channel_id)->first();
            $session_id = $subscription->session_id;

            // TODO : REPLACE WITH CHECKING FROM DB
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $checkout_session = Session::retrieve($session_id);
            $subscription_id = $checkout_session['subscription'];

            // create subscription
            $channel_obj = Channel::find($channel_id);
            if (!$channel_obj) {
                return redirect(route('channel.course', ['channel' => $channel_id]));
            }
            if (!($sub = Subscription::where('channel_id', $channel_id)->where('subscriber_id', \Auth::user()->id)->first())) {
                return redirect(route('channel.course', ['channel' => $channel_id]));
            }
            $sub->subscription_stripe_id = $subscription_id;
            $sub->save();

        } catch (Exception $e) {
            return redirect(route('channel.course', ['channel' => $channel_id]));
        }
        return redirect(route('channel.course', ['channel' => $channel_id]));
    }
}
