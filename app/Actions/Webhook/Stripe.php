<?php

namespace App\Actions\Webhook;

use App\Mail\Subscriptions\NewSubscriptionStudent;
use App\Mail\Subscriptions\NewSubscriptionTeacher;
use App\Models\Payment;
use App\Models\Channel;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Action;

class Stripe extends Action
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
    public function handle(Request $request)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $event = $request->getContent();
            // Parse the message body and check the signature
            $webhookSecret = env('STRIPE_WEBHOOK_SECRET');
            if ($webhookSecret) {
                try {
                    $event = \Stripe\Webhook::constructEvent(
                        $request->getContent(),
                        $request->header('stripe-signature'),
                        $webhookSecret
                    );
                } catch (\Throwable $e) {
                    return response()->json([], 422);
                }
            } else {
                $event = $request->getContent();
            }
            $type = $event['type'];
            $object = $event['data']['object'];

            /**
             * New Subscription
             */
            if ($type == 'checkout.session.completed' && $object['mode'] == 'subscription') {
                $subscription = Subscription::where('session_id', $object['id'])->first();
                if ($subscription) {

                    // Activate subscription
                    $subscription->actif = true;
                    $subscription->save();

                    // Update payment
                    $payment = Payment::create(
                        [
                            'subscription_id' => $subscription->id,
                            'stripe_payment_id' => $object['id'],
                            'stripe_price_id' => $object['lines']['data'][0]['price']['id'],
                            'payment_intent' => $object['payment_intent'],
                            'amount_paid' => $object['amount_total'],
                            'currency' => $object['currency'],
                            'status' => \strtoupper($object['payment_status']), // CANCELED || REFUNDED || PAID
                            'period_start' => $object['lines']['data'][0]['period']['start'],
                            'period_end' => $object['lines']['data'][0]['period']['end'],
                            'insctuctor_amount' => $object['amount_total'] * ((100 - env('THEDOJO_FEE_IN_PERCENT'))/100)
                        ]);

                        // Update Channel Balance
                        $channel = Channel::find($subscription->channel_id);
                        if($channel) {

                            $channel->balance_current = $channel->balance_current + $payment->insctuctor_amount ;
                            $channel->balance_total = $channel->balance_total + $payment->insctuctor_amount ;
                            $channel->save();

                        } else {
                            log::critical('Can not find channel'); 
                        }


                    try {
                        $teacher = User::find($subscription->user_id);
                        $student = User::find($subscription->subscriber_id);
                        Mail::to($student->email)->send(new NewSubscriptionStudent($teacher->email, $teacher->firstname, $teacher->lastname, ''));
                        Mail::to($teacher->email)->send(new NewSubscriptionTeacher($student->email, $student->firstname, $student->lastname, ''));
                    } catch (\Throwable $th) {
                    }

                } else {
                    log::critical('Can not cretae new subscription');
                }

                /**
                 * Subscription Updated
                 */
            } else if ($type == 'customer.subscription.updated') {

                // Cancel Subscription
                if ($object['cancel_at'] != null) {
                    //Log::info('Subscription Cancelled ');
                    /*$subscription = Subscription::where('subscription_stripe_id', $object['id'])->first();
                    if ($subscription) {
                    try {
                    //$teacher = User::find($subscription->user_id);
                    //$student = User::find($subscription->subscriber_id);
                    //Mail::to($student->email)->send(new NewSubscriptionStudent($teacher->email, $teacher->firstname, $teacher->lastname, ''));
                    //Mail::to($teacher->email)->send(new NewSubscriptionTeacher($student->email, $student->firstname, $student->lastname, ''));
                    } catch (\Throwable $th) {
                    }
                    } else {
                    log::warning('Can not update subscription maybe new subscription');
                    }*/

                    // Re-subscription
                } else {
                    //Log::info('Resubscription');
                }

                /**
                 * Invoice paid
                 */
            } else if ($type == 'invoice.updated') {
                //log::info('invoice.paid');
                //if ($object['paid']) {
                //log::info('Subscription is ' . $object['subscription']);
                //log::info('amount_paid is ' . $object['amount_paid']);
                //$object['subscription'] = 'sub_IxoDycg7tpkvse' ;

                // Get subscription
                $subscription = Subscription::where('subscription_stripe_id', $object['subscription'])->first();

                if ($subscription) {
                    // Update payment
                    /*Payment::create(
                        [
                            'subscription_id' => $subscription->id,
                            'stripe_payment_id' => $object['id'],
                            'stripe_price_id' => $object['lines']['data'][0]['price']['id'],
                            'payment_intent' => $object['payment_intent'],
                            'amount_paid' => $object['amount_paid'],
                            'currency' => $object['currency'],
                            'status' => \strtoupper($object['status']), // CANCELED || REFUNDED || PAID
                            'period_start' => $object['lines']['data'][0]['period']['start'],
                            'period_end' => $object['lines']['data'][0]['period']['end'],
                        ]);
                        */
                } else {
                   log::critical('Subscription not found ' . $object['subscription']);
                }

                // Update instructor fund
                //$object['amount_received']
                //}

                /**
                 * Charge refunded
                 */
            } else if ($type == 'charge.refunded') {

                /**
                 * Payment canceled
                 */
            } else if ($type == 'payment_intent.canceled') {

                /**
                 * Payment Failure
                 */
            } else if ($type == '??????') {

                /**
                 * Other case
                 */
            } else {
                //Log::info($type);
            }

            Log::info($type . ' => ' . $object['subscription']);

            return response()->json([], 200);
        } catch (\Throwable $e) {

            log::critical($e);

            return response()->json([], 422);
        }
    }
}
