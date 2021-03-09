<?php

namespace App\Actions\Web\Member\Channel\Video;

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
    public function handle(Request $request, $course_id = null, $section_id = null)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string', 'max:6000'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4000'],
            // 'video' => ['required', 'mimes:mp4', 'max:4000'],
            'topic' => ['required'],
            'language' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return redirect(route('video.create'))
                ->withInput()
                ->withErrors($validator);
        }
        try {
            $title = $request->get('title');
            $description = $request->get('description');
            $topic = $request->get('topic');
            $language = $request->get('language');
            $video = new Video();
            $redirect_to = null;
            if ($course_id && $section_id) {
                $course = Course::where('slug', $course_id)->first();
                $section = Section::find($section_id);
                if ($course && $section) {
                    $video->section_id = $section->id;
                    $video->course_id = $course->id;
                    $redirect_to = redirect(route('course.manage', ['course_slug' => $course->slug]));
                } else {
                    return redirect(route('video.create'))
                        ->withInput()
                        ->withErrors([
                            'Operation failed.'
                        ]);
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
                return redirect(route('video.create'))
                    ->withInput()
                    ->withErrors(['Operation failed.']);
            }
            $video->language = $language;
            $video->user_id = \Auth::user()->id;
            $channel = Channel::where('user_id', \Auth::user()->id)->first();
            if ($channel) {
                $video->channel_id = $channel->id;
            } else {
                return redirect(route('video.create'))
                    ->withInput()
                    ->withErrors(['Operation failed.']);
            }


            $sizeMin = min(getimagesize($request->file('thumbnail'))[0], getimagesize($request->file('thumbnail'))[1]);
            $sizeMax = max(getimagesize($request->file('thumbnail'))[0], getimagesize($request->file('thumbnail'))[1]);
            $space = intval(($sizeMax - $sizeMin) / 2);

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
            return redirect(route('video.create'))
                ->withInput()
                ->withErrors([
                    // 'Operation failed.'
                    $e->getMessage()
                ]);
        }
        if ($redirect_to) return $redirect_to;
        return redirect(route('video.list'));
    }
}
