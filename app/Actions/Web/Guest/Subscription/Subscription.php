<?php

namespace App\Actions\Web\Guest\Subscription;

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
        $pack = Pack::find($channel->pack_id);
        $instructor = $channel->user;

        // dd($pack);
        return view('guest/channel_subscribe', [
            'pack' => $pack,
            'channel' => $channel,
            'instructor' => $instructor
        ]);
    }
}
