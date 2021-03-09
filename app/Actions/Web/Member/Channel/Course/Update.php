<?php

namespace App\Actions\Web\Member\Channel\Course;

use Image;
use Exception;
use Validator;
use App\Models\Pack;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Channel;
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
    public function handle(Request $request, $slug)
    {
        $course = Course::where('slug', $slug)->first();
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'thumbnail' => 'nullable|image|mimeS:jpeg,png,jpg|max:4000',
            'topic' => ['required'],
            'published' => ['nullable'],
            'language' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect(route('course.edit', ['course_slug' => $slug]))
                ->withInput()
                ->withErrors($validator);
        }
        try {
            $title = $request->get('title');
            $description = $request->get('description');
            $topic = $request->get('topic');
            $language = $request->get('language');
            $published = $request->get('published') == null ? false : true;
            $course->title = $title;
            $course->description = $description;
            $topic = Topic::find($topic);
            if ($topic) {
                $course->topic_id = $topic->id;
            } else {
                return redirect(route('course.edit', ['course_slug' => $slug]))->withErrors([
                    'Operation failed.'
                    // $e->getMessage()
                ]);;
            }
            $course->language = $language;
            $course->user_id = \Auth::user()->id;
            if ($request->thumbnail) {
                Storage::disk('s3')->delete('courses/' . $course->thumbnail);

                $sizeMin = min(getimagesize($request->file('thumbnail'))[0], getimagesize($request->file('thumbnail'))[1]);
                $sizeMax = max(getimagesize($request->file('thumbnail'))[0], getimagesize($request->file('thumbnail'))[1]);
                $space = ($sizeMax - $sizeMin) / 2;

                $thumbnail_path = 'courses/' . time() . Str::random(10, 100) . '.' . $request->file('thumbnail')->getClientOriginalExtension();

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
                $course->thumbnail = Storage::disk('s3')->url($thumbnail_path);
            }
            $channel = Channel::where('user_id', \Auth::user()->id)->first();
            if ($channel) {
                $course->channel_id = $channel->id;
            } else {
                return redirect(route('course.edit', ['course_slug' => $slug]))->withErrors([
                    'Operation failed.'
                    // $e->getMessage()
                ]);;
            }
            $course->published = $published;
            $course->save();
        } catch (Exception $e) {
            return redirect(route('course.edit', ['course_slug' => $slug]))
                ->withErrors([
                    'Operation failed.'
                    // $e->getMessage()
                ]);
        }
        return redirect(route('channel'));
    }
}
