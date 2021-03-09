<?php

namespace App\Actions\API\Member\Channel;

use App\Models\Channel;
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
        $channel = \Auth::user()->channel();
        if (!$channel) {
            return response()->json([], 404);
        }
        $channel->delete();
        return response()->json([], 200);
    }
}
