<?php

namespace App\Actions\Web\Member\Channel\Live;

use App\Models\Live;
use App\Models\Topic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Action;

class Remove extends Action
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
            if (!$live) return response()->json([], 404);
            if ($live->miniature_thumbnail) {
                $arr = explode('/', $live->miniature_thumbnail);
                $file_name = $arr[sizeof($arr) - 1];
                $folder = $arr[sizeof($arr) - 2];
                Storage::disk('s3')->delete('/' . $folder . '/' . $file_name);
            }
            if ($live->thumbnail) {
                $arr = explode('/', $live->thumbnail);
                $file_name = $arr[sizeof($arr) - 1];
                $folder = $arr[sizeof($arr) - 2];
                Storage::disk('s3')->delete('/' . $folder . '/' . $file_name);
            }
            $live->delete();
        } catch (Exception $e) {
            return response()->json([], 422);
        }
        return redirect(route('live'));
    }
}
