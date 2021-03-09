<?php

namespace App\Actions\Web\Guest\Channel\About;

use App\Models\Channel;
use App\Models\Subscription;
use Lorisleiva\Actions\Action;

class Gallery extends Action
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

        $channelSubscribe = Channel::find($channel);
        if (!$channelSubscribe) abort(404);
        $user = $channelSubscribe->user;

        $isSubscriber = 0;
        if (\Auth::check())
            $isSubscriber = Subscription::where('channel_id', $channel)->where('actif', true)->where('subscriber_id', \Auth::user()->id)->count() > 0 ? true : false;
        $subscribersCount = Subscription::where('user_id', $channelSubscribe->user_id)->count();

        // if (!\Auth::user()->channel())
        //     $isSubscriber = false;
        // else {
        //     if ($channel == \Auth::user()->channel()->id)
        //         $isSubscriber = true;
        // }

        return view('guest/channel/channel_gallery', [
            'user' => $user,
            'isSubscriber' => $isSubscriber,
            'subscribersCount' => $channelSubscribe->SubscriptionsCount
        ]);
    }
}
