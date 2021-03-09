<?php

namespace App\Actions\Web\Member\Channel\Gallery;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Show extends Action
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
        $picture = Gallery::where('path', $request->path)->first();

        return view("member/channel/channel_gallery", [
            'picture' => $picture,
        ]);
    }
}
