<?php

namespace App\Actions\API\Member\Channel\Course\Section;

use App\Models\Channel;
use App\Models\Course;
use App\Models\Section;
use Validator;
use App\Models\Topic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;

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
    public function handle(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],

        ]);
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 422);
        }
        try {
            $course = Course::where('slug', $slug)->first();
            $title = $request->get('title');
            $description = $request->get('description');
            $section = new Section();
            $section->course_id = $course->id;
            $section->title = $title;
            $section->description = $description;
            $order = ($tmp = Section::where('course_id', $course->id)->max('order')) !==null ? $tmp + 1 : 0;
            $section->order = $order;
            $section->visible = true;
            $section->save();
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 422);
        }
        return response()->json(['course' => $slug], 200);
    }
}
