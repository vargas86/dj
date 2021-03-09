<?php

namespace App\Actions\Web\User\Gallery;

use App\Models\Gallery;
use Exception;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Storage;

class Delete extends Action
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
    public function handle($gallery_id)
    {
        // this action for deleting galleries in users profil

        try {
            $gallery = Gallery::findOrFail($gallery_id);
            if ($gallery->path) {
                $arr = explode('/', $gallery->path);
                $file_name = $arr[sizeof($arr) - 1];
                $folder = $arr[sizeof($arr) - 2];
                Storage::disk('s3')->delete('/' . $folder . '/' . $file_name);
            }
            if ($gallery->thumbnail) {
                $arr = explode('/', $gallery->thumbnail);
                $file_name = $arr[sizeof($arr) - 1];
                $folder = $arr[sizeof($arr) - 2];
                Storage::disk('s3')->delete('/' . $folder . '/' . $file_name);
            }

            $gallery->delete();
            return response()->json([], 200);
        } catch (Exception $e) {
            return response()->json([], 422);
        }
    }
}
