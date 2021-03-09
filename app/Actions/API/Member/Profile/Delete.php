<?php

namespace App\Actions\API\Member\Profile;

use App\Models\Channel;
use App\Models\User;
use Lorisleiva\Actions\Action;

class Delete extends Action
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
        if (!\Auth::user()) {
            return response()->json([], 422);
        }
        $channel = Channel::where('user_id', \Auth::user()->id)->first();
        if ($channel) $channel->delete();
        \Auth::user()->delete();
        return response()->json([], 200);
    }
}
