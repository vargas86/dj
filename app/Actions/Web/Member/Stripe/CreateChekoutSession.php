<?php

namespace App\Actions\Web\Member\Stripe;

use App\Models\Channel;
use App\Models\Pack;
use App\Models\Subscription;
use DateTime;
use Exception;
use Lorisleiva\Actions\Action;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

class CreateChekoutSession extends Action
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

            $pack_id = request()->input('packId');
            $channel_id = request()->input('channelId');

            // get pack price_stripe_id
            $pack = Pack::find($pack_id);
            if (!$pack)
                return response()->json([], 404);
            $price_id = $pack->price_stripe_id;

            // create checkout session
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $checkout_session = Session::create([
                'success_url' => route('subscription.create') . '?pack_id=' . $pack->id . '&channel_id=' . $channel_id . '&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('channel.course', ['channel' => $channel_id]),
                'payment_method_types' => ['card'],
                'mode' => 'subscription',
                'line_items' => [[
                    'price' => $price_id,
                    'quantity' => 1,
                ]],
            ]);

            $price = $checkout_session['amount_total'];
            $currency = $checkout_session['currency'];

            $channel_obj = Channel::find($channel_id);
            if (!$channel_obj) {
                return response()->json([], 404);
            }
            if (!($sub = Subscription::where('channel_id', $channel_id)->where('subscriber_id', \Auth::user()->id)->first())) {
                $sub = new Subscription();
                $sub->start = new DateTime();
            }
            $sub->user_id = $channel_obj->user_id;
            $sub->channel_id = $channel_obj->id;
            $sub->subscriber_id = \Auth::user()->id;
            $sub->session_id = $checkout_session['id'];
            $sub->price = $price;
            $sub->currency = $currency;
            $sub->pack_id = $pack_id;
            $sub->actif = false;
            $sub->save();
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ], 400);
        }

        return response()->json(['sessionId' => $checkout_session['id']]);
    }
}
