<?php

namespace App\Actions\Web\Member\Channel\Video;

use App\Models\Live;
use App\Models\Pack;
use App\Models\Topic;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Create extends Action
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
    public function handle(Request $request, $course_slug = null, $section_id = null)
    {
        $topics = Topic::where('topic_id', null)->get();
        return view(
            "member/channel/video/create",
            [
                'topics' => $topics,
                'course_id' => $course_slug,
                'section_id' => $section_id
            ]
        );
    }
}
