<?php

namespace App\Actions\Web\Pages;

use App\Models\Channel;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;

class NewestCourses extends Action
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

        $courses = Course::where('courses.published', true)
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
            ->orderBy('courses.created_at', 'DESC')
            ->select('courses.id as id', 'courses.title as title', 'courses.user_id as user_id', 'courses.slug as slug', 'courses.thumbnail as thumbnail', 'courses.description as description', 'courses.topic_id as topic_id', 'courses.channel_id as channel_id');
        if (auth()->check()) {
            $courses = $courses->where('courses.user_id', '<>', auth()->user()->id);
        }
        $courses = $courses->paginate(12);
        if (request()->get('page')) {
            return view('pages/newest_courses_pagination', [
                'courses' => $courses,
            ]);
        }


        return view('pages/newest_courses', [
            'courses' => $courses,
        ]);
    }
}
