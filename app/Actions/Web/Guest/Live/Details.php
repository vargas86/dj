<?php

namespace App\Actions\Web\Guest\Live;

use App\Models\Chat;
use App\Models\Live;
use App\Models\Subscription;
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
    public function handle(Request $request, $live_slug)
    {
        if (auth()->check()) {
            $live = Live::where('slug', $live_slug)->first();
            if (!$live) abort(404);
            $is_subscribed = Subscription::where('subscriber_id', auth()->user()->id)->where('user_id', $live->user_id)->where('actif', true)->where(function ($query) {
                $query->where('end', '>', date('Y-m-d'))
                    ->orWhere('end', null);
            })->count();
            if (!$is_subscribed) abort(404);
            $chat = Chat::where('live_id', $live->id)->get();
            return view('guest/live/details')->with([
                'live' => $live,
                'chat' => $chat,
            ]);
        }
        abort(404);
    }
}
