<?php

namespace App\Actions\API\Member\Channel\Live;

use App\Models\Live;
use App\Models\Topic;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Submit extends Action
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
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4000'],
            'topic' => ['required'],
            'schedule' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 422);;
        }
        try {
            $title = $request->get('title');
            $description = $request->get('description');
            $topic = $request->get('topic');
            $language = $request->get('language');
            $schedule = $request->get('schedule');
            $disabled = $request->get('disabled');
            $chat = $request->get('chat');
            $live = new Live();
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
            $live->user_id = \Auth::user()->id;
            $thumbnail = $live->id . '_thumbnail_' . time() . '.' . $request->thumbnail->getClientOriginalExtension();
            $request->thumbnail->storeAs('public/lives/', $thumbnail);
            $live->chat = ($chat == null ? false : true);
            $live->thumbnail = $thumbnail;
            $live->published = ($disabled == null ? false : true);
            $live->save();
        } catch (Exception $e) {
            return response()->json([], 422);
        }
        return response()->json([], 422);
    }
}
