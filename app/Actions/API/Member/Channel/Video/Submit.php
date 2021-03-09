<?php

namespace App\Actions\API\Member\Channel\Video;

use Image;
use Exception;
use Validator;
use App\Models\Topic;
use App\Models\Video;
use App\Models\Course;
use App\Models\Channel;
use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    public function handle(Request $request, $course_slug = null, $section_id = null)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4000'],
            'topic' => ['required'],
            'language' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 422);
        }
        try {
            $title = $request->get('title');
            $description = $request->get('description');
            $topic = $request->get('topic');
            $language = $request->get('language');
            $video = new Video();
            if ($course_slug && $section_id) {
                $course = Course::where('slug', $course_slug)->first();
                $section = Section::find($section_id);
                if ($course && $section) {
                    $video->section_id = $section->id;
                    $video->course_id = $course->id;
                } else {
                    return response()->json([], 422);
                }
            }
            $video->title = $title;
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_';
            $result = '';
            for ($i = 0; $i < 11; $i++) {
                $result .= $characters[mt_rand(0, 63)];
            }
            $statement = DB::select("show table status like 'videos'");
            $result .= $statement[0]->Auto_increment;
            $video->slug = $result;
            $video->description = $description;
            $topic = Topic::find($topic);
            if ($topic) {
                $video->topic_id = $topic->id;
            } else {
                return response()->json([], 422);
            }
            $video->language = $language;
            $video->user_id = \Auth::user()->id;
            $channel = Channel::where('user_id', \Auth::user()->id)->first();
            if ($channel) {
                $video->channel_id = $channel->id;
            } else {
                return response()->json([], 422);
            }


            $sizeMin = min(getimagesize($request->file('thumbnail'))[0], getimagesize($request->file('thumbnail'))[1]);
            $sizeMax = max(getimagesize($request->file('thumbnail'))[0], getimagesize($request->file('thumbnail'))[1]);
            $space = (($sizeMax - $sizeMin) / 2);

            $thumbnail_path = 'videos/' . time() . Str::random(10, 100) . '.' . $request->file('thumbnail')->getClientOriginalExtension();

            $sizeMin = min(getimagesize($request->file('thumbnail'))[0], getimagesize($request->file('thumbnail'))[1]);
            $sizeMax = max(getimagesize($request->file('thumbnail'))[0], getimagesize($request->file('thumbnail'))[1]);
            $space = ($sizeMax - $sizeMin) / 2;

            if (getimagesize($request->file('thumbnail'))[0] > getimagesize($request->file('thumbnail'))[1]) {
                $thumbnail = Image::make($request->file('thumbnail'))->crop($sizeMin, $sizeMin, $space, 0, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
            } else {
                $thumbnail = Image::make($request->file('thumbnail'))->crop($sizeMin, $sizeMin, 0, $space, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
            }

            Storage::disk('s3')->put($thumbnail_path, $thumbnail, 'public');
            $video->thumbnail = Storage::disk('s3')->url($thumbnail_path);


            $video->free = false;
            $video->duration = 0;
            $video->url = 'http://www.google.fr/';
            $video->save();
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 422);
        }
        return response()->json([], 200);
    }
}
