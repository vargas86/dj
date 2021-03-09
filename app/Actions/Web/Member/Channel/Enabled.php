<?php

namespace App\Actions\Web\Member\Channel;

use App\Models\Channel;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Enabled extends Action
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
        $channel = Channel::where('user_id', \Auth::user()->id)->first();
        $channel->active = true;
        $channel->save();

        return redirect(route("channel"));
    }
}
