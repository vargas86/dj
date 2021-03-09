<?php

namespace App\Actions\API\Member\Subscription;

use App\Models\Channel;
use App\Models\Subscription;
use Exception;
use Lorisleiva\Actions\Action;

class Submit extends Action
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
        try {
            $channel_obj = Channel::find($channel);
            if (!$channel_obj)
                return response()->json([], 422);
            $sub = new Subscription();
            $sub->user_id = $channel_obj->user_id;
            $sub->channel_id = $channel_obj->id;
            if (\Auth::check())
                $sub->subscriber_id = \Auth::user()->id;
            else
                return response()->json([], 422);
            $sub->pack_id = $channel_obj->pack_id;
            $sub->actif = true;
            $sub->save();
        } catch (Exception $e) {
            return response()->json([], 422);
        }
        return response()->json(['channel' => $channel], 200);
    }
}
