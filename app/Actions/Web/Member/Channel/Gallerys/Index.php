<?php

namespace App\Actions\Web\Member\Channel\Gallery;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Index extends Action
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
    public function handle(Request $request)
    {

        if (\Auth::user()->channels->count() < 1) {
            return redirect(route('channel.active1'));
        }

        return view("member/channel/channel_gallery", [
            'user' => \Auth::user()
        ]);
    }
}
