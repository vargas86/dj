<?php

namespace App\Actions\API\Member\Channel\Live;

use App\Models\Live;
use App\Models\Topic;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

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
    public function handle(Request $request, $stream)
    {
        try {
            $live = Live::find($stream);
            if ($live) {
                $validator = Validator::make($request->all(), [
                    'title' => ['required', 'string'],
                    'description' => ['required', 'string'],
                    'thumbnail' => ['image', 'mimes:jpeg,png,jpg', 'max:4000'],
                    'topic' => ['required'],
                    'schedule' => ['required', 'string'],
                ]);
                if ($validator->fails()) {
                    return response()->json([$validator->errors()], 422);
                }
                $title = $request->get('title');
                $description = $request->get('description');
                $topic = $request->get('topic');
                $language = $request->get('language');
                $schedule = $request->get('schedule');
                $disabled = $request->get('disabled');
                $chat = $request->get('chat');
                $live->title = $title;
                $live->slug = \Str::slug($title, '_');
                $live->schedule = date_create($schedule);
                $live->description = $description;
                $topic = Topic::find($topic);
                if ($topic) {
                    $live->topic_id = $topic->id;
                } else {
                    return response()->json([], 422);
                }
                $live->language = $language;
                if ($request->thumbnail) {
                    $thumbnail = $live->id . '_thumbnail_' . time() . '.' . $request->thumbnail->getClientOriginalExtension();
                    $request->thumbnail->storeAs('public/lives/', $thumbnail);
                    $live->thumbnail = $thumbnail;
                }
                $live->chat = ($chat == null ? false : true);
                $live->published = ($disabled == null ? false : true);
                $live->save();
                return response()->json(['stream' => $stream], 200);
            }
        } catch (Exception $e) {
            return response()->json([], 422);
        }
    }
}
