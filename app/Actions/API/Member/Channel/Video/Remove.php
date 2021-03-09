<?php

namespace App\Actions\API\Member\Channel\Video;

use Exception;
use App\Models\Video;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Storage;

class Remove extends Action
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
        try {
            $video = Video::where('slug', $video_slug)->first();

            if (!$video) {
                return response()->json([], 404);
            }
            Storage::disk('s3')->delete('videos/' . $video->thumbnail);
            Storage::disk('s3')->delete('videos/' . $video->miniature_thumbnail);
            $video->delete();
            return response()->json([], 200);
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 422);
        }
    }
}
