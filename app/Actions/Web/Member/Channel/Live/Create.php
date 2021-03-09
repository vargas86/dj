<?php

namespace App\Actions\Web\Member\Channel\Live;

use App\Models\Live;
use App\Models\Topic;
use Lorisleiva\Actions\Action;

class Create extends Action
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
        $topics = Topic::where('topic_id', null)->get();
        return view('member/channel/live/create');
    }
}
