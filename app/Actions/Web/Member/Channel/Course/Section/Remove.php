<?php

namespace App\Actions\Web\Member\Channel\Course\Section;

use App\Models\Channel;
use App\Models\Course;
use App\Models\Section;
use Validator;
use App\Models\Topic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function handle(Request $request, $section_id)
    {
        try {
            $section = Section::findOrFail($section_id);
            $course_slug = $section->course->slug;
            $section->delete();
        } catch (Exception $e) {
            return redirect(route('channel'));
        }
        return redirect(route('course.manage', ['course_slug' => $course_slug]));
    }
}
