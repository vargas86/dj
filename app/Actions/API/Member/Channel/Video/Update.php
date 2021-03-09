<?php

namespace App\Actions\API\Member\Channel\Video;

use Image;
use Exception;
use Validator;
use App\Models\Topic;
use App\Models\Video;
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
    public function handle(Request $request, $video_slug)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'topic_id' => ['required'],
            'language' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 422);
        }
        try {
            $title = $request->get('title');
            $description = $request->get('description');
            $topic_id = $request->get('topic_id');
            $language = $request->get('language');
            $video = Video::where('slug', $video_slug)->first();
            if (!$video)
                return response()->json([], 404);
            $video->title = $title;
            $video->description = $description;
            $topic = Topic::find($topic_id);
            if ($topic) {
                $video->topic_id = $topic->id;
            } else {
                return response()->json([], 422);
            }
            $video->language = $language;
            $video->save();
        } catch (Exception $e) {
            return response()->json([], 422);
        }
        return response()->json(['video' => $video], 200);
    }
}
