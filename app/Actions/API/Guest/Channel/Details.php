<?php

namespace App\Actions\API\Guest\Channel;

use App\Models\Channel;
use App\Models\Video;
use App\Models\Course;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
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
    public function handle($channel_id)
    {
        $channel = Channel::where('id', $channel_id)->where('active', true)->first();
        if (!$channel) return response()->json([], 404);
        return response()->json([
            'channel' => $channel
        ], 200);
    }
}
