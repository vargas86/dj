<?php

namespace App\Actions\API\Guest\Course;

use App\Models\Course;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class View extends Action
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
        return response()->json([
            'course' => $course,
        ], 200);
    }
}
