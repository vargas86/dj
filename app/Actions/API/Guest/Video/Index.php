<?php

namespace App\Actions\API\Guest\Video;

use App\Models\Course;
use App\Models\Pack;
use App\Models\Section;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use App\Models\Videoquality;
use Lorisleiva\Actions\Action;
use Illuminate\Http\Request;

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
        try {
            $query = Video::where('published', true)->where('course_id', null)->where('section_id', null);
            if (auth()->check()) $query->where('user_id', '<>', auth()->user()->id);
            $videos = $query->paginate(10)->toArray();
            return response()->json(['videos' => $videos], 200);
        } catch (\Throwable $e) {
            return response()->json([], 422);
        }
    }
}
