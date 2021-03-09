<?php

namespace App\Actions\Web\Guest\Course;

use Exception;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use DB;

class Index extends Action
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
        try {
            $data = DB::table('courses')
                ->where('courses.published', true)
                ->join('users as instructor', 'instructor.id', '=', 'courses.user_id')
                ->join('topics', 'topics.id', '=', 'courses.topic_id')
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
                    DB::raw('(select v.section_id, min(v.order) as latest from videos v where v.published = 1 and group by v.section_id) as q'),
                    function ($join) {
                        $join->on('videos.order', '=', 'q.latest')
                            ->whereColumn('videos.section_id', 'q.section_id');
                    }
                )->orderBy('videos.order', 'ASC')
                ->whereColumn('videos.section_id', 'sections.id')
                ->addSelect('courses.slug as course.slug', 'courses.thumbnail as course.thumbnail', 'courses.title as course.title')
                ->addSelect('instructor.firstname as instructor.firstname', 'instructor.lastname as instructor.lastname', 'instructor.avatar as instructor.avatar')
                ->addSelect('videos.slug as video.slug')
                ->addSelect('sections.id as section.id')
                ->addSelect('topics.title as topic.title', 'topics.abbreviation as topic.abbreviation');
            if (\Auth::check()) $data->where('instructor.id', '<>', \Auth::user()->id);
            $data = $data->get();
            $data = json_decode(json_encode($data), true);
            $result = [];
            foreach ($data as $item) {
                $result[] = [
                    'topic' => [
                        'title' => $item['topic.title'],
                        'abbreviation' => $item['topic.abbreviation'],
                    ],
                    'instructor' => [
                        'avatar' => $item['instructor.avatar'],
                        'name' => $item['instructor.firstname'] . ' ' . $item['instructor.lastname'],
                    ],
                    'course' => [
                        'thumbnail' => $item['course.thumbnail'],
                        'title' => $item['course.title'],
                        'slug' => $item['course.slug'],
                    ],
                    'video' => [
                        'slug' => $item['video.slug'],
                    ],
                    'section' => [
                        'id' => $item['section.id'],
                    ],
                ];
            }
            // dd($result);
        } catch (Exception $e) {
            return redirect(route('home'));
        }
        return view('guest/course/list')->with('courses', $result);
    }
}
