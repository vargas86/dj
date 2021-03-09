<?php

namespace App\Actions\Web\Guest\Channel\About;

use App\Models\Channel;
use App\Models\Live;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
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
        if (!$channelSubscribe) abort(404);
        $user = $channelSubscribe->user;

        $isSubscriber = 0;
        if (\Auth::check())
            $isSubscriber = Subscription::where('channel_id', $channel)->where('actif', true)->where('subscriber_id', \Auth::user()->id)->count() > 0 ? true : false;
        $subscribersCount = Subscription::where('user_id', $channelSubscribe->user_id)->count();

        // Lives
        $lives = Live::where('user_id', $user->id)->where('published', true)->select( 'slug' ,'id' ,'title', DB::raw('DATE_FORMAT(schedule , "%Y-%m-%d") as start'))->get()->toArray();

        return view('guest/channel/channel_schedule', [
            'user' => $user,
            'isSubscriber' => $isSubscriber,
            'subscribersCount' => $channelSubscribe->SubscriptionsCount,
            'lives' => json_encode($lives),
        ]);
    }
}
