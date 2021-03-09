<?php

namespace App\Actions\Web\Member\Channel\Course;

use App\Models\Course;
use App\Models\Live;
use App\Models\Pack;
use App\Models\Topic;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Edit extends Action
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
        $topics = Topic::where('topic_id', null)->get();
        return view("member/channel/course/edit", ['course' => $course, 'topics' => $topics]);
    }
}
