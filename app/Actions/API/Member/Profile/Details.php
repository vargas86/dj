<?php

namespace App\Actions\API\Member\Profile;

use Exception;
use Validator;
use App\Models\Pack;
use App\Models\Video;
use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Http\Request;
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
    public function handle(Request $request)
    {

        return response()->json([
            'user' => \Auth::user()
        ], 200);
    }
}
