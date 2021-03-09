<?php

namespace App\Actions\Web\Member\Channel\Live;

use App\Models\Live;
use App\Models\Topic;
use Exception;
use Validator;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    public function handle(Request $request, $live_id)
    {
        try {
            $live = Live::find($live_id);
            if (!$live) abort(404);
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string'],
                'description' => ['required', 'string'],
                'thumbnail' => ['image', 'mimes:jpeg,png,jpg', 'max:4000'],
                'topic' => ['required'],
                'schedule' => ['required', 'string'],
            ]);
            if ($validator->fails()) {
                return redirect(route('live.edit', ['live_id' => $live_id]))
                    ->withInput()
                    ->withErrors($validator);
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
                return redirect(route('live.edit', ['live_id' => $live_id]))
                    ->withInput()
                    ->withErrors(['Operation failed.']);
            }
            $live->language = $language;

            $live->chat = ($chat == null ? false : true);
            $live->published = ($disabled == null ? false : true);

            //Thumbnail
            if ($request->thumbnail) {

                Storage::disk('s3')->delete('videos/' . $live->thumbnail);
                Storage::disk('s3')->delete('videos/' . $live->miniature_thumbnail);

                $w = getimagesize($request->file('thumbnail'))[0];
                $h = getimagesize($request->file('thumbnail'))[1];

                $thumbnail_path = 'lives/' . ($n = time() . \Str::random(10, 100)) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
                $miniature_thumbnail_path = 'lives/miniature_' . $n . '.' . $request->file('thumbnail')->getClientOriginalExtension();

                if ($w > $h) {
                    $thumbnail = Image::make($request->file('thumbnail'))->resize(780, null, function ($constraint) {
                        $constraint->aspectRatio();
                        // $constraint->upsize();
                    })->encode();
                    $miniature_thumbnail = 'data://text/plain;base64,' . base64_encode($thumbnail);
                    $miniature_thumbnail = Image::make($request->thumbnail)->resize(null, 168, function ($constraint) {
                        $constraint->aspectRatio();
                        // $constraint->upsize();
                    })->encode();
                } else {
                    $thumbnail = Image::make($request->file('thumbnail'))->resize(null, 390, function ($constraint) {
                        $constraint->aspectRatio();
                        // $constraint->upsize();
                    })->encode();
                    $miniature_thumbnail = 'data://text/plain;base64,' . base64_encode($thumbnail);
                    $miniature_thumbnail = Image::make($request->thumbnail)->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                        // $constraint->upsize();
                    })->encode();
                }
                $tmp = 'data://text/plain;base64,' . base64_encode($miniature_thumbnail);
                $miniature_X = getimagesize($tmp)[0];
                $miniature_Y = getimagesize($tmp)[1];

                if ($miniature_X >= 300) $x = intval(($miniature_X - 300) / 2);
                else $x = intval((300 - $miniature_X) / 2);
                if ($miniature_Y >= 168) $y = intval(($miniature_Y - 168) / 2);
                else $y = intval((168 - $miniature_Y) / 2);
                $miniature_thumbnail = Image::make($miniature_thumbnail)->crop(300, 168, $x, $y)->encode();
                Storage::disk('s3')->put($miniature_thumbnail_path, $miniature_thumbnail, 'public');
                Storage::disk('s3')->put($thumbnail_path, $thumbnail, 'public');
                $live->miniature_thumbnail = Storage::disk('s3')->url($miniature_thumbnail_path);
                $live->thumbnail = Storage::disk('s3')->url($thumbnail_path);
            }
            $live->save();
            return redirect(route('live'));
        } catch (Exception $e) {
            return redirect(route('live.edit', ['live_id' => $live_id]))->withErrors(['Operation failed!']);
        }
    }
}
