<?php

namespace App\Actions\API\User\Gallery;

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
    public function handle(Request $request, $gallery_id)
    {

        try {
            $gallery = Gallery::find($gallery_id);
            if (!$gallery) return response()->json([], 404);
            Storage::disk('s3')->delete('galleries/' . $gallery->path);
            $gallery->delete();
        } catch (Exception $e) {
            return response()->json([], 422);
        }
        return response()->json([], 200);
    }
}
