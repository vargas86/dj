<?php

namespace App\Actions\API\Member\Channel\Video;

use App\Models\Video;
use Validator;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Action;

class Thumbnail extends Action
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
            // Validation
            $validator = Validator::make($request->all(), [
                'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4000'],
            ]);
            if ($validator->fails()) {
                return response()->json([$validator->errors()->all()], 422);
            }

            $video = Video::where('slug', $video_slug)->first();
            if (!$video)
                return response()->json([], 404);

            // 780x 390 , 240 x 140
            if ($request->thumbnail) {

                Storage::disk('s3')->delete('videos/' . $video->thumbnail);
                Storage::disk('s3')->delete('videos/' . $video->miniature_thumbnail);

                $w = getimagesize($request->file('thumbnail'))[0];
                $h = getimagesize($request->file('thumbnail'))[1];

                $thumbnail_path = 'videos/' . ($n = time() . \Str::random(10, 100)) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
                $miniature_thumbnail_path = 'videos/miniature_' . $n . '.' . $request->file('thumbnail')->getClientOriginalExtension();

                if ($w > $h) {
                    $thumbnail = Image::make($request->file('thumbnail'))->resize(780, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                    $miniature_thumbnail = Image::make($request->file('thumbnail'))->resize(240, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                } else {
                    $thumbnail = Image::make($request->file('thumbnail'))->resize(null, 390, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                    $miniature_thumbnail = Image::make($request->file('thumbnail'))->resize(null, 140, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                }

                $tmp = 'data://text/plain;base64,' . base64_encode($miniature_thumbnail);

                $miniature_X = getimagesize($tmp)[0];
                $miniature_Y = getimagesize($tmp)[1];

                if ($miniature_X > 240) $x = 0;
                else $x = intval((240 - $miniature_X) / 2);
                if ($miniature_Y > 140) $y = 0;
                else $y = intval((140 - $miniature_Y) / 2);

                $miniature_thumbnail = Image::make($miniature_thumbnail)->crop(240, 140, $x, $y)->encode();

                Storage::disk('s3')->put($miniature_thumbnail_path, $miniature_thumbnail, 'public');
                Storage::disk('s3')->put($thumbnail_path, $thumbnail, 'public');
                $video->miniature_thumbnail = Storage::disk('s3')->url($miniature_thumbnail_path);
                $video->thumbnail = Storage::disk('s3')->url($thumbnail_path);
            } else {
                return response()->json([], 422);
            }
            $video->save();
            return response()->json(["video_slug" => $video->slug], 200);
        } catch (\Exception $e) {
            return response()->json([], 422);
        }
    }
}
