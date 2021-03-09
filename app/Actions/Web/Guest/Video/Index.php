<?php

namespace App\Actions\Web\Guest\Video;

use Lorisleiva\Actions\Action;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

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
    public function handle()
    {
        $query = Video::where('videos.published', true)
            ->join('users', 'users.id', '=', 'videos.user_id')
            ->where('users.deleted_at', null)
            ->where('videos.status', 'e')
            ->where('videos.section_id', null)
            ->where('videos.course_id', null);
        if (\Auth::check()) $query->where('videos.user_id', '<>', \Auth::user()->id);
        $videos = $query->get();
        $data = [];
        foreach ($videos as $video) {
            $data[] = [
                'id' => $video->id,
                'slug' => $video->slug,
                'thumbnail' => $video->thumbnail,
                'title' => $video->title,
                'topic' => $video->topicName(),
                'duration' => $video->duration,
                'channel_id' => $video->channel_id,
                'instructor' => [
                    'name' => $video->user->firstname . ' ' . $video->user->firstname,
                    'avatar' => $video->user->avatar,
                ],
            ];
        }
        return view('guest/video/list', ['videos' => $data]);
    }
}
