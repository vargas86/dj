<?php

namespace App\Actions\Web\Member\Channel;

use Exception;
use Validator;
use App\Models\Pack;
use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Storage;

class Subscribe extends Action
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
        if(\Auth::check()) {
            $user = \Auth::user() ;

            // Get channel
            $channel = Channel::find($channel_id);
            if($channel) {

                // Check if channel is actif
                if(!$channel->active) {
                    return 'channel not actif' ;
                }

                // Check if user already subscribed
                $subscription = Subscription::where('channel_id', $channel->id)->where('subscriber_id', $user->id)->get()->count() ;
                if(!$subscription) {

                    try {
                        $newSubscription = new Subscription();
                        
                            $newSubscription->actif = true;
                            $newSubscription->user_id = $channel->user_id;
                            $newSubscription->pack_id = $channel->pack_id;
                            $newSubscription->subscription_stripe_id = null;
                            $newSubscription->session_id = null;
                            $newSubscription->currency = 'usd';
                            $newSubscription->price = 0;
                            $newSubscription->start = now();
                            $newSubscription->end = null;
                            $newSubscription->subscriber_id = $user->id;
                            $newSubscription->channel_id = $channel->id;

                            $newSubscription->save();

                        return 'success';

                    } catch (\Throwable $th) {
                        return 'error';
                    }

                } else {
                    return 'already subscribed';
                }
            } else {
                return 'no channel';
            }
        }
        return 'no';
    }
}
