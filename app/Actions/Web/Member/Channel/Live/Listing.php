<?php

namespace App\Actions\Web\Member\Channel\Live;

use App\Models\Live;
use Lorisleiva\Actions\Action;

class Listing extends Action
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
    public function handle()
    {
        $lives = Live::where('user_id', \Auth::user()->id)->get();
        return view('member/channel/live/list')->with(['lives' => $lives]);
    }
}
