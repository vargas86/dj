<?php

namespace App\Actions\Web\Member\Channel\Live;

use App\Models\Live;
use App\Models\Topic;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Edit extends Action
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
        $live = Live::find($live_id);
        if ($live) {
            return view('member/channel/live/edit')->with(['live' => $live]);
        } else {
            return redirect(route('live'));
        }
    }
}
