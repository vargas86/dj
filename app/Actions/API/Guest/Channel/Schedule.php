<?php

namespace App\Actions\API\Guest\Channel;

use App\Models\Channel;
use App\Models\Subscription;
use Lorisleiva\Actions\Action;

class Schedule extends Action
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
        if (!$channelSubscribe) return response()->json([], 404);
        $user = $channelSubscribe->user;
        if (\Auth::check())
            $isSubscriber = Subscription::where('channel_id', $channel)->where('subscriber_id', \Auth::user()->id)->count() > 0 ? true : false;
        else $isSubscriber = false;

        $subscribersCount = Subscription::where('user_id', $channelSubscribe->user_id)->count();

        return response()->json([
            'user' => $user,
            'isSubscriber' => $isSubscriber,
            'subscribersCount' => $subscribersCount
        ], 200);
    }
}
