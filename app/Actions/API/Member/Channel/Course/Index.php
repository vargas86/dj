<?php

namespace App\Actions\API\Member\Channel\Course;

use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\DB;

class Index extends Action
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
        $courses = Course::where('user_id', \Auth::user()->id)->paginate(5);
        foreach ($courses as $course) {
            $nbrVideos[$course->id] = Video::where('course_id', $course->id)->count() ?? 0;
        }

        if (\Auth::user()->channels->count() < 1) {
            return response()->json([], 422);

            return response()->json(
                [
                    'courses' => $courses,
                    'nomberVideo' => $nbrVideos ?? 0
                ],
                200
            );
        }
        return response()->json(
            [],
            422
        );
    }
}
