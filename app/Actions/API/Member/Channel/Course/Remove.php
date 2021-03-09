<?php

namespace App\Actions\API\Member\Channel\Course;

use Exception;
use Validator;
use App\Models\Pack;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Channel;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Storage;

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
    public function handle(Request $request, $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return response()->json([], 422);
        }
        try {
            Storage::disk('s3')->delete('courses/' . $course->thumbnail);
            $course->delete();
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 422);
        }
        return response()->json([], 200);
    }
}
