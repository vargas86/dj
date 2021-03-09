<?php

namespace App\Actions\Web\Member\Channel\Live;

use App\Models\Chat;
use App\Models\Live;
use Lorisleiva\Actions\Action;
use App\Models\Topic;
use Illuminate\Http\Request;

class Stream extends Action
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
    public function handle(Request $request, $live_id)
    {

        $live = Live::where('id', $live_id)->where('user_id', auth()->user()->id)->first();
        if (!$live) abort(404);
        $chat = Chat::where('live_id', $live->id)->get();
        return view('member/channel/live/stream', [
            'live' => $live,
            'chat' => $chat,
        ]);
    }
}
