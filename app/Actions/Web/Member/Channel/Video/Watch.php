<?php

namespace App\Actions\Web\Member\Channel\Video;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Section;
use App\Models\Subscription;
use App\Models\Video;
use App\Models\Videoquality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;
use stdClass;

class Watch extends Action
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
    public function handle(Request $request, $video_slug)
    {

        // TODO : REORGANIZE CONDITIONS
        $video = Video::where('slug', $video_slug)->where('section_id', null)->where('course_id', null)->first();
        $user = null;
        if (!$video) abort(404);
        if ((auth()->check() && auth()->user()->id !== $video->user_id) || !auth()->check()) {
            $video = Video::where('slug', $video_slug)->where('section_id', null)->where('course_id', null)->where('published', true)->first();
        }
        if (!$video) abort(404);
        $comments = Comment::where('comments.video_id', $video->id)->where('comments.parent_id', null)
        ->join('users', 'users.id', 'comments.user_id')
        ->where('users.deleted_at', null)
        ->orderBy('comments.created_at', 'DESC')
        ->addSelect('comments.id as id', 'comments.text as text', 'comments.user_id as user_id', 'comments.video_id as video_id', 'comments.parent_id as parent_id', 'comments.created_at as created_at')
        ->paginate(10);
        $teacher = $video->user;
        $channel = Channel::where('user_id', $teacher->id)->first();
        $subscribers_number = Subscription::where('user_id', $teacher->id)->count();
        $locked = false;
        if (!$video->free) {
            if (\Auth::check()) {
                $is_subscribed = Subscription::where('subscriber_id', \Auth::user()->id)->where('actif', true)->where(function ($query) {
                    $query->where('end', '>', date('Y-m-d'))
                        ->orWhere('end', null);
                })->count();
                if (!$is_subscribed && $video->user_id != auth()->user()->id) {
                    $sources = new stdClass();
                    $sources->type = 'video';
                    if ($video->thumbnail) {
                        $sources->poster = $video->thumbnail;
                    }
                    $sources->title = $video->title ? $video->title : '';
                    $src = new stdClass();
                    $src->src = 'none';
                    $src->type = 'video/mp4';
                    $sources->sources[] = $src;
                    $locked = true;
                } else {
                    // IF CONVERT COMPLETE
                    $user = auth()->user();
                    if ($video->status == 'e') {
                        $videoqualities = Videoquality::where('video_id', $video->id)->get();
                        $sources = new stdClass();
                        $sources->type = 'video';
                        if ($video->thumbnail) {
                            $sources->poster = $video->thumbnail;
                        }
                        $sources->title = $video->title ? $video->title : '';
                        foreach ($videoqualities as $source) {
                            $src = new stdClass();
                            $src->src = $source->url;
                            $src->type = 'video/mp4';
                            $src->size = $source->quality;
                            $sources->sources[] = $src;
                        }
                    } else {
                        // CONVERT NOT COMPLETE (SHOW ORIGINAL VIDEO)
                        $sources = new stdClass();
                        $sources->type = 'video';
                        if ($video->thumbnail) {
                            $sources->poster = $video->thumbnail;
                        }
                        $sources->title = $video->title ? $video->title : '';
                        $src = new stdClass();
                        $src->src = '/storage/videos/' . $video->filename;
                        $src->type = 'video/mp4';
                        $sources->sources[] = $src;
                    }
                }
            } else {
                $sources = new stdClass();
                $sources->type = 'video';
                if ($video->thumbnail) {
                    $sources->poster = $video->thumbnail;
                }
                $sources->title = $video->title ? $video->title : '';
                $src = new stdClass();
                $src->src = 'none';
                $src->type = 'video/mp4';
                $sources->sources[] = $src;
                $locked = true;
            }
        } else {
            // IF CONVERT COMPLETE
            $user = auth()->user();
            if ($video->status == 'e') {
                $videoqualities = Videoquality::where('video_id', $video->id)->get();
                $sources = new stdClass();
                $sources->type = 'video';
                if ($video->thumbnail) {
                    $sources->poster = $video->thumbnail;
                }
                $sources->title = $video->title ? $video->title : '';
                foreach ($videoqualities as $source) {
                    $src = new stdClass();
                    $src->src = $source->url;
                    $src->type = 'video/mp4';
                    $src->size = $source->quality;
                    $sources->sources[] = $src;
                }
            } else {
                // CONVERT NOT COMPLETE (SHOW ORIGINAL VIDEO)
                $sources = new stdClass();
                $sources->type = 'video';
                if ($video->thumbnail) {
                    $sources->poster = $video->thumbnail;
                }
                $sources->title = $video->title ? $video->title : '';
                $src = new stdClass();
                $src->src = '/storage/videos/' . $video->filename;
                $src->type = 'video/mp4';
                $sources->sources[] = $src;
            }
        }

        $videoSources = $video->videoSources;

        // WATCH SIMPLE VIDEO (STANDALONE)
        return view(
            "member/channel/video/watch",
            [
                'locked' => $locked,
                'channel' => $channel,
                'video' => $video,
                'subscribers_number' => $subscribers_number,
                'teacher' => $teacher,
                'sources' => json_encode($sources),
                'user' => json_encode($user),
                'comments' => $comments,
                'videoSources' => $videoSources
            ]
        );
    }
}
