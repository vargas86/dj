<?php

namespace App\Actions\Web\Member\Profile;

use Exception;
use Validator;
use App\Models\Pack;
use App\Models\Video;
use App\Models\Channel;
use App\Models\Subscription;
use App\Models\Topic;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Details extends Action
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
        $totalSubscription = Subscription::where('user_id', \Auth::user()->id)->count();
        $nomberVideoUpload = Video::where('user_id', \Auth::user()->id)->count();
        $active_subscriptions = Subscription::where('subscriber_id', \Auth::user()->id)->where('actif', 1)->count();

        $topic = '';
        if (\Auth::user()->topic_id)
            $topic = ($topic = Topic::find(\Auth::user()->topic_id)) ? $topic->title : '' ;
        return view('member/profile/details', [
            'topic' => $topic,
            'user' => \Auth::user(),
            'active_subscriptions' => $active_subscriptions,
            'totalSubscription' => $totalSubscription,
            'nomberVideoUpload' => $nomberVideoUpload
        ]);
    }
}
