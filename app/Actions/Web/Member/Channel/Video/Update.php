<?php

namespace App\Actions\Web\Member\Channel\Video;

use App\Models\Topic;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Lorisleiva\Actions\Action;
use Validator;

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
    public function handle(Request $request, $video_slug, $course_slug, $section_id)
    {
        $redirect_to = null;
        if ($course_slug) {
            $redirect_to = redirect(route('course.manage', ['course_slug' => $course_slug]));
        }
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string', 'max:6000'],
            'thumbnail' => [
                'image',
                'mimes:jpeg,png,jpg',
                'max:4000',
                'dimensions:min_width=500,min_height=280,max_width:2000,max_height=1000',
            ],
            'topic' => ['required'],
            'language' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return redirect(route('video.edit', ['video_slug' => $video_slug, 'course_slug' => $course_slug, 'section_id' => $section_id]))
                ->withInput()
                ->withErrors($validator);
        }
        try {
            $title = $request->get('title');
            $published = $request->get('published') == null ? false : true;
            $free = $request->get('free') == null ? false : true;
            $description = $request->get('description');
            $topic = $request->get('topic');
            $language = $request->get('language');
            $video = Video::where('slug', $video_slug)->first();
            if (!$video) {
                abort(404);
            }

            $video->title = $title;
            $video->published = $published;
            $video->free = $free;
            $video->description = $description;
            $topic = Topic::find($topic);
            if ($topic) {
                $video->topic_id = $topic->id;
            } else {
                return redirect(route('video.edit', ['video_slug' => $video_slug, 'course_slug' => $course_slug, 'section_id' => $section_id]))
                    ->withInput()
                    ->withErrors(['Operation failed kk.']);
            }
            $video->language = $language;

            if ($request->thumbnail) {

                // Delete old pictures
                Storage::disk('s3')->delete('videos/' . $video->thumbnail);
                Storage::disk('s3')->delete('videos/' . $video->miniature_thumbnail);

                $thumbnail_path = 'videos/' . ($n = time() . Str::random(10, 100)) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
                $miniature_thumbnail_path = 'videos/miniature_' . $n . '.' . $request->file('thumbnail')->getClientOriginalExtension();

                $w = getimagesize($request->file('thumbnail'))[0];
                $h = getimagesize($request->file('thumbnail'))[1];

                if ($w > $h) {
                    $thumbnail = Image::make($request->file('thumbnail'))->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                    $miniature_thumbnail = Image::make($request->file('thumbnail'))->resize(240, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                    // $tmp = 'data://text/plain;base64,' . base64_encode($miniature_thumbnail);
                    // dd(getimagesize($tmp));
                } else {
                    $thumbnail = Image::make($request->file('thumbnail'))->resize(null, 280, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                    $miniature_thumbnail = Image::make($request->file('thumbnail'))->resize(null, 135, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                    // $tmp = 'data://text/plain;base64,' . base64_encode($miniature_thumbnail);
                    // dd(getimagesize($tmp));
                }

                $tmp = 'data://text/plain;base64,' . base64_encode($miniature_thumbnail);
                $miniature_X = getimagesize($tmp)[0];
                $miniature_Y = getimagesize($tmp)[1];

                if ($miniature_X > 240) {
                    $x = 0;
                } else {
                    $x = intval((240 - $miniature_X) / 2);
                }

                if ($miniature_Y > 135) {
                    $y = 0;
                } else {
                    $y = intval((135 - $miniature_Y) / 2);
                }

                $miniature_thumbnail = Image::make($miniature_thumbnail)->crop(240, 135, $x, $y)->encode();

                Storage::disk('s3')->put($miniature_thumbnail_path, $miniature_thumbnail, 'public');
                Storage::disk('s3')->put($thumbnail_path, $thumbnail, 'public');
                $video->miniature_thumbnail = Storage::disk('s3')->url($miniature_thumbnail_path);
                $video->thumbnail = Storage::disk('s3')->url($thumbnail_path);
            }
            $video->save();
        } catch (Exception $e) {
            return redirect(route('video.edit', ['video_slug' => $video_slug, 'course_slug' => $course_slug, 'section_id' => $section_id]))
                ->withInput()
                ->withErrors([
                    //'Operation failed !',
                    $e->getMessage()
                ]);
        }
        if ($redirect_to) {
            return $redirect_to;
        }

        return redirect(route('video.list'));
    }
}
