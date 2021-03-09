<?php

namespace App\Actions\Web\Pages;

use App\Models\Channel;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;

class Home extends Action
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
        if (auth()->check()) {
            $courses = $this->videoAndSectionExists(
                Course::where('courses.user_id', '<>', auth()->user()->id)
                    ->where('courses.published', true)
                    ->inRandomOrder()
            )->paginate(8);
            $newest_courses = $this->videoAndSectionExists(
                Course::orderBy('courses.created_at', 'DESC')
                    ->where('courses.user_id', '<>', auth()->user()->id)
                    ->where('courses.published', true)
            )->paginate(4);
            $channels = Channel::inRandomOrder()
                ->where('user_id', '<>', auth()->user()->id)
                ->paginate(3);
            $topic_id = ($tmp = Topic::join('courses', 'courses.topic_id', '=', 'topics.id')
                ->addSelect(DB::raw('count(courses.id) as total'), 'courses.topic_id')
                ->join('sections', 'sections.course_id', '=', 'courses.id')
                ->join(
                    DB::raw('(select s.course_id, min(s.order) as latest from sections s where s.published = 1 group by s.course_id) as r'),
                    function ($join) {
                        $join->on('sections.order', '=', 'r.latest')
                            ->whereColumn('sections.course_id', 'r.course_id');
                    }
                )
                ->join('videos', 'videos.section_id', '=', 'sections.id')
                ->join(
                    DB::raw('(select v.section_id, min(v.order) as latest from videos v where v.published = 1 group by v.section_id) as q'),
                    function ($join) {
                        $join->on('videos.order', '=', 'q.latest')
                            ->whereColumn('videos.section_id', 'q.section_id');
                    }
                )
                ->whereColumn('videos.section_id', 'sections.id')
                ->where('courses.published', true)
                ->groupBy('courses.topic_id')
                ->havingRaw('total >= 4')
                ->inRandomOrder()) ? $tmp->first()['topic_id'] : null;
            $random_courses = null;
            $random_topic = null;
            if ($topic_id) {
                $random_topic = Topic::find($topic_id);
                $random_courses =
                    $this->videoAndSectionExists(
                        Course::where('courses.topic_id', '=', $topic_id)
                            ->where('courses.user_id', '<>', auth()->user()->id)
                            ->where('courses.published', true)
                    )->paginate(4);
            }
        } else {
            $courses = $this->videoAndSectionExists(
                Course::inRandomOrder()
                    ->where('courses.published', true)
            )->paginate(8);
            $newest_courses = $this->videoAndSectionExists(
                Course::orderBy('courses.created_at', 'DESC')
                    ->where('courses.published', true)
            )->paginate(4);
            $channels = Channel::inRandomOrder()
                ->paginate(3);
            $topic_id = ($tmp = Topic::join('courses', 'courses.topic_id', '=', 'topics.id')
                ->addSelect(DB::raw('count(courses.id) as total'), 'courses.topic_id')
                ->join('sections', 'sections.course_id', '=', 'courses.id')
                ->join(
                    DB::raw('(select s.course_id, min(s.order) as latest from sections s where s.published = 1 group by s.course_id) as r'),
                    function ($join) {
                        $join->on('sections.order', '=', 'r.latest')
                            ->whereColumn('sections.course_id', 'r.course_id');
                    }
                )
                ->join('videos', 'videos.section_id', '=', 'sections.id')
                ->join(
                    DB::raw('(select v.section_id, min(v.order) as latest from videos v where v.published = 1 group by v.section_id) as q'),
                    function ($join) {
                        $join->on('videos.order', '=', 'q.latest')
                            ->whereColumn('videos.section_id', 'q.section_id');
                    }
                )
                ->whereColumn('videos.section_id', 'sections.id')
                ->where('courses.published', true)
                ->groupBy('courses.topic_id')
                ->havingRaw('total >= 4')
                ->inRandomOrder()) ? $tmp->first()['topic_id'] : null;
            $random_courses = null;
            $random_topic = null;
            if ($topic_id) {
                $random_topic = Topic::find($topic_id);
                $random_courses =
                    $this->videoAndSectionExists(
                        Course::where('courses.topic_id', '=', $topic_id)
                            ->where('courses.published', true)
                    )->paginate(4);
            }
        }
        return view('home', [
            'courses' => $courses,
            'newest_courses' => $newest_courses,
            'channels' => $channels,
            'random_courses' => $random_courses,
            'random_topic' => $random_topic,

        ]);
    }

    protected function videoAndSectionExists($query)
    {
        return $query->join('sections', 'sections.course_id', '=', 'courses.id')
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
            ->join('users', 'users.id', '=', 'courses.user_id')
            ->join('channels', 'users.id', '=', 'channels.user_id')
            ->where('users.deleted_at', '=', null)
            ->select('courses.id as id', 'courses.title as title', 'courses.channel_id as channel_id', 'courses.user_id as user_id', 'courses.slug as slug', 'courses.thumbnail as thumbnail', 'courses.description as description', 'courses.topic_id as topic_id')
            ->addSelect('channels.additional as additional');
    }
}
