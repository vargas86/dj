<?php

namespace App\Actions\Web\Guest\Topic;

use App\Models\Course;
use Lorisleiva\Actions\Action;
use App\Models\Topic;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class Courses extends Action
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
    public function handle($path)
    {
        $path = explode('/', $path);
        $slug = end($path);
        $topic = Topic::where('slug', $slug)->where('disabled', false)->first();
        if (!$topic) abort(404);
        $topics = Topic::where('topic_id', $topic->id)->get('id')->toArray();
        foreach ($topics as $key => $value) {
            $topics[$key] = $value['id'];
        }
        array_push($topics, $topic->id);
        $query = Course::whereIn('courses.topic_id', $topics)
            ->where('courses.published', true)
            ->join('users', 'users.id', '=', 'courses.user_id')
            ->whereNull('users.deleted_at')
            ->join('sections', 'sections.course_id', '=', 'courses.id')
            ->join(
                DB::raw('(select s.course_id, min(s.order) as latest from sections s where s.published = 1 group by s.course_id) as r'),
                function ($join) {
                    $join->on('sections.order', '=', 'r.latest')
                        ->whereColumn('sections.course_id', 'r.course_id');
                }
            )->orderBy('sections.order', 'ASC')
            ->join('videos', 'videos.section_id', '=', 'sections.id')
            ->join(
                DB::raw('(select v.section_id, min(v.order) as latest from videos v where v.published = 1 group by v.section_id) as q'),
                function ($join) {
                    $join->on('videos.order', '=', 'q.latest')
                        ->whereColumn('videos.section_id', 'q.section_id');
                }
            )->orderBy('videos.order', 'ASC')
            ->whereColumn('videos.section_id', 'sections.id')
            ->select('courses.id as id', 'courses.title as title', 'courses.user_id as user_id', 'courses.slug as slug', 'courses.thumbnail as thumbnail', 'courses.description as description', 'courses.channel_id as channel_id', 'courses.topic_id as topic_id');
        if (\Auth::check()) $query->where('courses.user_id', '<>', auth()->user()->id);
        $courses = $query->paginate(12);
        if(request()->get('page')){
            return view('topic/courses_pagination', ['courses' => $courses]);
        }

        return view('topic/courses', ['topic' => $topic, 'courses' => $courses]);
    }
}
