<?php

namespace App\Actions\Web\Video;

use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Upload extends Action
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
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'video' => 'required|mimes:mp4,mov,avi',
        ]);

        if ($validator->fails()) {
            return $validator->messages()->messages();
        }

        $file = $request->file('video');
        $resp = Storage::disk('s3')->put('v', $file, 'public');
        $url = Storage::disk('s3')->url($resp);

        // Save to DB



        // Execute the action.
        return $url;
    }
}
