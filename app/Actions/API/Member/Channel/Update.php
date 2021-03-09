<?php

namespace App\Actions\API\Member\Channel;

use Exception;
use Validator;
use App\Models\Pack;
use App\Models\Channel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Storage;

class Update extends Action
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
        try {
            $validator = Validator::make($request->all(), [
                'price' => ['required', 'numeric'],
                'privileges' => ['required', 'string', 'min:20'],
            ]);
            if ($validator->fails()) {
                return response()->json([$validator->errors()], 422);
            }
            $channel = \Auth::user()->channel();
            if (!$channel) return response()->json([], 404);
            $subscription_price = $request->get('price');
            $privileges = $request->get('privileges');
            $channel->pack->price = $subscription_price;
            $channel->pack->privileges = $privileges;
            $channel->pack->save();
            return response()->json([], 200);
        } catch (Exception $e) {
            return response()->json([], 422);
        }
    }
}
