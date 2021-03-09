<?php

namespace App\Actions\API\Member\Channel\Gallery;

use App\Models\Gallery;
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
        $galleries = Gallery::where('user_id', \Auth::user()->id)->paginate(10);

        return response()->json([
            'galleries' => $galleries
        ], 200);
    }
}
