<?php

namespace App\Actions\API\Guest\Channel;

use App\Models\Channel;
use App\Models\Subscription;
use Lorisleiva\Actions\Action;

class About extends Action
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
        $channel = Channel::find($channel);
        if (!$channel)
            return response()->json([], 404);

        $user = $channel->user;

        if (\Auth::check())
            $isSubscriber = Subscription::where('channel_id', $channel)->where('subscriber_id', \Auth::user()->id)->count() > 0 ? true : false;
        else $isSubscriber = false;

        $subscribersCount = Subscription::where('user_id', $channel->user_id)->count();

        return response()->json([
            'user' => $user,
        ], 200);
    }
}
