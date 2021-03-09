<?php

namespace App\Actions\API\Member\Channel\Video;

use App\Models\Video;
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
    public function handle(Request $request, $video_slug)
    {
        $video = Video::where('slug', $video_slug)->first();
        if (!$video) return response()->json([], 404);
        return response()->json(['video' => $video], 200);
    }
}
