<?php

namespace App\Actions\API\Guest\Subscription;

use App\Models\Pack;
use App\Models\Channel;
use Lorisleiva\Actions\Action;

class Subscription extends Action
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
        $channel = Channel::find($channel);
        $pack = Pack::where('id', $channel->pack_id)->get();
        $instructor = $channel->user;
        return response()->json([
            'pack' => $pack,
            'channel' => $channel,
            'instructor' => $instructor
        ], 200);
    }
}
