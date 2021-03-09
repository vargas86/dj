<?php

namespace App\Actions\API\Member\Channel\Live;

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
    public function handle(Request $request, $stream)
    {
        // $live = Live::find($stream);
        // $view = view('member/channel/live/stream');
        // if ($live) {
        //     return $view->with('live', $live);
        // }
        // return $view;
    }
}
