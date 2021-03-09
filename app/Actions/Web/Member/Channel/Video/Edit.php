<?php

namespace App\Actions\Web\Member\Channel\Video;

use App\Models\Topic;
use App\Models\Video;
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
    public function handle(Request $request, $video_slug, $course_slug = null, $section_id = null)
    {
        $video = Video::where('slug', $video_slug)->first();
        $topics = Topic::where('topic_id', null)->get();

        return view("member/channel/video/edit")->with(['video' => $video, 'topics' => $topics, 'course_slug' => $course_slug, 'section_id' => $section_id]);
    }
}
