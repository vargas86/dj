<?php

namespace App\Actions\Web\Guest\Search;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;

class CourseSearch extends Action
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
    public function handle(Request $request, $keyword)
    {
        $keyword = preg_replace('/\++/', ' ', $keyword);

            $courses = DB::table('courses')
            ->join('videos', 'videos.course_id', '=', 'courses.id')
            ->join('sections', 'sections.course_id', '=', 'courses.id')
            ->join('users', 'users.id', '=', 'courses.user_id')
            ->join('channels', function ($join) {
                $join->on('channels.id', '=', 'courses.channel_id')
                ->where('channels.active', '=', 1)
                ->where('channels.deleted_at', '=', NULL);
            })
        // Search in courses
            ->where(function ($query) use ($keyword) {
                // Title
                $query->where(function ($query) use ($keyword) {
                    $query->where('courses.title', 'like', '%' . $keyword . '%');
                    $query->where('courses.published', '=', 1);
                });
                // Description
                $query->orWhere(function ($query) use ($keyword) {
                    $query->where('courses.description', 'like', '%' . $keyword . '%');
                    $query->where('courses.published', '=', 1);
                });
            })
        // Search in videos
            ->orWhere(function ($query) use ($keyword) {
                // Title
                $query->where(function ($query) use ($keyword) {
                    $query->where('videos.title', 'like', '%' . $keyword . '%');
                    $query->where('videos.published', '=', 1);
                    $query->where('courses.published', '=', 1);
                });
                // Description
                $query->orWhere(function ($query) use ($keyword) {
                    $query->where('videos.description', 'like', '%' . $keyword . '%');
                    $query->where('videos.published', '=', 1);
                    $query->where('courses.published', '=', 1);
                });
            })
        // Search in sections
            ->orWhere(function ($query) use ($keyword) {
                $query->where('sections.title', 'like', '%' . $keyword . '%');
                $query->where('videos.published', '=', 1);
                $query->where('courses.published', '=', 1);
                $query->where(function ($query) {
                    $query->select(DB::raw('COUNT(*)'))
                        ->from('videos')
                        ->whereColumn('videos.section_id', 'sections.id')
                        ->where('videos.published', 1)
                        ->limit(1);
                }, '>', 0);
            })
            // Select
            ->select('courses.id', 'courses.thumbnail', 'courses.slug', 'courses.title', 'courses.description')
            ->addSelect(DB::raw('CONCAT(users.firstname, " ", users.lastname) as user_name'))
            ->addSelect(DB::raw('channels.id as channel_id'))
            ->addSelect(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(videos.duration))) as duration"))
            ->addSelect(DB::raw("(SELECT count(*) FROM videos
                WHERE videos.channel_id = channels.id
                AND videos.published = 1
            ) as VideosCount"))
            ->groupBy('courses.id')
            ->paginate(10);  


        if ($request->ajax() || $request->isXmlHttpRequest()) {
            return view('guest/search/ajax_course', compact('keyword', 'courses'));
        } else {
            return view('guest/search/course', compact('keyword', 'courses'));
        }
    }
}
