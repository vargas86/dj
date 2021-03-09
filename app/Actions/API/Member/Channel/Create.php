<?php

namespace App\Actions\API\Member\Channel;

use App\Models\Channel;
use App\Models\Pack;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Action;
use Validator;

class Create extends Action
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
        $validator = Validator::make($request->all(), [
            'price' => ['required', 'numeric'],
            'privileges' => ['required', 'string', 'min:20'],
            // 'cover_image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:4000'],
        ]);
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 422);
        }
        try {
            $price = $request->get('price');
            $privileges = $request->get('privileges');
            $pack = new Pack();
            $pack->user_id = \Auth::user()->id;
            $pack->price = $price;
            $pack->privileges = $privileges;
            $pack->save();
            $channel = new Channel();
            $channel->user_id = \Auth::user()->id;
            $channel->pack_id = $pack->id;
            // if ($request->file('cover_image')) {
            //     $path = $request->file('cover_image')->storePublicly('channel_covers', 's3');
            //     // $channel->cover_image = Storage::disk('s3')->url($path);
            // }
            $channel->save();
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 422);
        }
        return response()->json([], 200);
    }
}
