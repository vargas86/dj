<?php

namespace App\Actions\Web\Guest\Search;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;

class VideoSearch extends Action
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

        // Videos
        $videos = DB::table('videos')
            ->join('users', 'users.id', '=', 'videos.user_id')
            ->join('channels', function ($join) {
                $join->on('channels.id', '=', 'videos.channel_id')
                ->where('channels.active', '=', 1)
                ->where('channels.deleted_at', '=', NULL)
                ;
            })
                ->where(function ($query) use ($keyword) {
                $query->where('videos.title', 'like', '%' . $keyword . '%')
                    ->orWhere('videos.description', 'like', '%' . $keyword . '%');
            })
            ->select('videos.*')
            ->addSelect(DB::raw('CONCAT(users.firstname, " ", users.lastname) as user_name'))
            ->addSelect(DB::raw('channels.id as channel_id'))
            ->where('videos.published', '=', 1)
            ->where('videos.course_id', '=', null)
            ->paginate(10);

        if ($request->ajax() || $request->isXmlHttpRequest()) {
            return view('guest/search/ajax_video', compact('keyword', 'videos'));
        } else {
            return view('guest/search/video', compact('keyword', 'videos'));
        }
    }
}
