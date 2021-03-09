<?php

namespace App\Actions\Web\User\Gallery;

use Image;
use Validator;
use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
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
    public function handle(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'gallery_file' => 'required|image|mimes:jpeg,png,jpg|max:5000',
            ]);

            if ($validator->fails()) return response()->json([$validator->errors()->first()], 422);

            $gallery = new Gallery();
            $time = time() . Str::random(10, 100);
            $gallery_file_full_path = 'galleries/' . 'full_' . $time . '.' . $request->file('gallery_file')->getClientOriginalExtension();
            $gallery_file_path = 'galleries/'  . $time . '.' . $request->file('gallery_file')->getClientOriginalExtension();

            //calcule heigth and width
            $sizeX = getimagesize($request->file('gallery_file'))[0];
            $sizeY = getimagesize($request->file('gallery_file'))[1];

            //full picture
            if ($sizeX > $sizeY) {
                $gallery_file_full = Image::make($request->file('gallery_file'))->resize(992, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
                $thumbnail = 'data://text/plain;base64,' . base64_encode($gallery_file_full);
                $thumbnail = Image::make($thumbnail)->resize(null, 250, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
            } else {
                $gallery_file_full = Image::make($request->file('gallery_file'))->resize(null, 631, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
                $thumbnail = 'data://text/plain;base64,' . base64_encode($gallery_file_full);
                $thumbnail = Image::make($thumbnail)->resize(250, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
            }

            //storage full picture
            Storage::disk('s3')->put($gallery_file_full_path, $gallery_file_full, 'public');
            $gallery->path = Storage::disk('s3')->url($gallery_file_full_path);
            $gallery->user_id = \Auth::user()->id;

            $tmp = 'data://text/plain;base64,' . base64_encode($thumbnail);

            $thumbnailX = getimagesize($tmp)[0];
            $thumbnailY = getimagesize($tmp)[1];
            $x = 0;
            $y = 0;
            if ($thumbnailX > $thumbnailY) {
                $x = intval(($thumbnailX - $thumbnailY) / 2);
            } elseif ($thumbnailX < $thumbnailY) {
                $y = intval(($thumbnailY - $thumbnailX) / 2);
            }

            $gallery_file = Image::make($thumbnail)->crop(250, 250, $x, $y)->encode();

            //storage picture
            Storage::disk('s3')->put($gallery_file_path, $gallery_file, 'public');
            $gallery->thumbnail = Storage::disk('s3')->url($gallery_file_path);
            $gallery->save();

            return response()->json([], 200);
        } catch (\Exception $e) {
            return response()->json(['Upload failed. Try again later.'], 422);
        }
    }
}
