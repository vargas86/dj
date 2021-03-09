<?php

namespace App\Actions\Web\Guest\Channel\About;

use App\Models\User;
use App\Models\Channel;
use App\Models\Subscription;
use App\Models\Topic;
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
        $channelSubscribe = Channel::findorFail($channel);
        if (!$channelSubscribe)
            return redirect()->route('home');

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
        $topic = ($topic = Topic::find($user->topic_id)) ? $topic->title : '';
        return view("guest/channel/channel_about", [
            'user' => $user,
            'topic' => $topic,
            'isSubscriber' => $isSubscriber,
            'subscribersCount' => $channelSubscribe->SubscriptionsCount,
        ]);
    }
}
