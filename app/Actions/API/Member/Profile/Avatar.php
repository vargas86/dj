<?php

namespace App\Actions\API\Member\Profile;

use Illuminate\Support\Str;
use Validator;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Action;

class Avatar extends Action
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
        try {
            $validator = Validator::make(request()->all(), [
                'avatar' => ['required', 'image', 'mimes:png,jpg,jpeg']
            ]);
            if ($validator->fails()) return response()->json([$validator->errors()->all()], 422);
            $avatar = request()->avatar;
            $avatar_path = 'users/' . time() . Str::random(10, 100) . '.' . request()->file('avatar')->getClientOriginalExtension();
            Storage::disk('s3')->put($avatar_path, file_get_contents(request()->file('avatar')), 'public');
            \Auth::user()->avatar = Storage::disk('s3')->url($avatar_path);
            \Auth::user()->save();

            return response()->json(['avatar' => \Auth::user()->avatar], 200);
        } catch (\Throwable $e) {
            return response()->json([], 422);
        }
    }
}
