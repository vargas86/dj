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

class Update extends Action
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
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],

        ]);
        if ($validator->fails()) {
            return redirect(route('section.edit', ['section_id' => $section_id]))
                ->withInput()
                ->withErrors($validator);
        }
        try {
            $section = Section::findOrFail($section_id);
            $course_slug = $section->course->slug;
            $title = $request->get('title');
            $description = $request->get('description');
            $published = $request->get('published') ? true : false;
            $section->title = $title;
            $section->description = $description;
            $section->published = $published;
            $section->save();
        } catch (Exception $e) {
            return redirect(route('section.edit', ['section_id' => $section_id]))
                ->withErrors([
                    // 'Operation failed.'
                    $e->getMessage()
                ]);
        }

        return redirect(route('course.manage', ['course_slug' => $course_slug]));
    }
}
