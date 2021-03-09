<?php

namespace App\Actions\API\User\Gallery;

use Image;
use Validator;
use App\Models\Gallery;
use Exception;
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
                'gallery_file' => ['required', 'mimes:jpg,jpeg,png', 'max:5000']
            ]);
            if ($validator->fails()) return response()->json([$validator->errors()], 422);

            $galleryFull = new Gallery();
            $time = time() . Str::random(10, 100);
            $gallery_file_full_path = 'galleries/' . 'full_' . $time . '.' . $request->file('gallery_file')->getClientOriginalExtension();
            $gallery_file_path = 'galleries/'  . $time . '.' . $request->file('gallery_file')->getClientOriginalExtension();

            //calcule heigth and width
            $sizeX = getimagesize($request->file('gallery_file'))[0];
            $sizeY = getimagesize($request->file('gallery_file'))[1];
            $sizeMin = min($sizeX, $sizeY);
            $sizeMax = max($sizeX, $sizeY);
            $space = ($sizeMax - $sizeMin) / 2;


            //full picture
            if ($sizeX > $sizeY) {
                $gallery_file_full = Image::make($request->file('file'))->crop($sizeX, $sizeY, $space, 0, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
            } else {
                $gallery_file_full = Image::make($request->file('file'))->crop($sizeX, $sizeY, 0, $space, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
            }


            //storage full picture
            Storage::disk('s3')->put($gallery_file_full_path, $gallery_file_full, 'public');
            $galleryFull->path = Storage::disk('s3')->url($gallery_file_full_path);

            $galleryFull->user_id = \Auth::user()->id;
            $galleryFull->save();

            //picture 
            if (getimagesize($request->file('gallery_file'))[0] > getimagesize($request->file('gallery_file'))[1])
                $gallery_file = Image::make($request->file('gallery_file'))->crop($sizeMin, $sizeMin, $space, 0)->encode();
            else
                $gallery_file = Image::make($request->file('gallery_file'))->crop($sizeMin, $sizeMin, 0, $space)->encode();

            //storage picture
            $gallery = new Gallery();
            Storage::disk('s3')->put($gallery_file_path, $gallery_file, 'public');
            $gallery->path = Storage::disk('s3')->url($gallery_file_path);
            $gallery->user_id = \Auth::user()->id;
            $gallery->save();

            return response()->json([], 200);
        } catch (Exception $e) {
            return response()->json([], 422);
        }
    }
}
