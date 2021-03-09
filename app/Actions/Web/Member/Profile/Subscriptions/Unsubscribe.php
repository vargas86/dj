<?php

namespace App\Actions\Web\Member\Profile\Subscriptions;

use App\Mail\Subscriptions\UnSubscriptionStudent;
use App\Mail\Subscriptions\UnSubscriptionTeacher;
use App\Models\Channel;
use App\Models\Subscription;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Action;
use Stripe\StripeClient;

class Unsubscribe extends Action
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
    public function handle(Request $request, $channel_id)
    {
        try {
            if ($channel = Channel::find($channel_id)) {
                $subscription = Subscription::where('subscriber_id', \Auth::user()->id)
                    ->where('channel_id', $channel_id)
                    ->first();
                if (!$subscription || !$subscription->subscription_stripe_id) {
                    return redirect(route('profile.subscriptions'));
                }

                $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
                $stripe_subscription = $stripe->subscriptions->update($subscription->subscription_stripe_id, [
                    'cancel_at_period_end' => true,
                ]);
                $endDate = date('Y-m-d h:i:sP', $stripe_subscription['cancel_at']);
                $endDate = new DateTime($endDate);
                $subscription->end = $endDate;
                $subscription->actif = false;
                $subscription->save();
                $teacher = User::find($channel->user_id);
                $student = \Auth::user();
                try {
                    Mail::to($student->email)->send(new UnSubscriptionStudent($teacher->email, $teacher->firstname, $teacher->lastname, ''));
                    Mail::to($teacher->email)->send(new UnSubscriptionTeacher($student->email, $student->firstname, $student->lastname, ''));
                } catch (\Throwable $th) {

                }
                return redirect(route('profile.subscriptions'));
            }
        } catch (Exception $e) {
            return redirect(route('profile.subscriptions'));
        }
    }
}
