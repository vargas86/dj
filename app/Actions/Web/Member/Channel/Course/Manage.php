<?php

namespace App\Actions\Web\Member\Channel\Course;

use App\Models\Course;
use App\Models\Pack;
use App\Models\Section;
use App\Models\Video;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Manage extends Action
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
    public function handle(Request $request, $course_slug)
    {
        $course = Course::where('slug', $course_slug)->first();
        $sections = Section::where('course_id', $course->id)->orderBy('order', 'ASC')->get();
        $videos = null;
        foreach ($sections as $section) {
            $videos[$section->id] = Video::where('course_id', $course->id)->where('section_id', $section->id)->orderBy('order', 'ASC')->get();
        }
        return view("member/channel/course/manage", ['course' => $course, 'sections' => $sections, 'videos' => $videos]);
    }
}
