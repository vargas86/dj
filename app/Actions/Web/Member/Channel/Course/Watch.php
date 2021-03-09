<?php

namespace App\Actions\Web\Member\Channel\Course;

use App\Models\Channel;
use App\Models\Course;
use App\Models\Subscription;
use App\Models\Video;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

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
    public function handle(Request $request, $course_slug, $video_slug = null)
    {

        $course = Course::where('slug', $course_slug)->first();
        if (!$course) {
            abort(404);
        }
        $course->makeVisible('user_id');

        // Show unpublished course for owner only
        if(!$course->published) {
            if (\Auth::check()) {
                if (\Auth::user()->id != $course->user->id) abort(404);
            } else {
                abort(404);
            }
        }

        // Video
        if ($video_slug) {
            $video = Video::where('course_id', $course->id)->where('slug', $video_slug)->first();
            if(!$video) abort(404);

            if(!$video->published) {
                if (\Auth::check()) {
                    if (\Auth::user()->id != $course->user->id) abort(404);
                } else {
                    abort(404);
                }  
            }
            
        } else {
            if (!isset($course->sections()->get()[0]) || !isset($course->sections()->get()[0]->videos()->get()[0])) {
                abort(404);
            }
            $video = $course->sections()->get()[0]->videos()->get()[0]->makeVisible('order');
        }
        $videoSources = $video->videoSources;

        // Locked
        $locked = true;
        if ($video->free) {
            $locked = false;
        } else {

            if (\Auth::check()) {

                if (\Auth::user()->id == $course->user->id) {
                    $locked = false;
                } else {
                    $locked = !Subscription::where('subscriber_id', \Auth::user()->id)
                        ->where('user_id', $course->user->id)
                        ->where('actif', true)
                        ->where(function ($query) {
                            $query->where('end', '>', date('Y-m-d'))
                                ->orWhere('end', null);
                        })->count();
                }
            }
        }
        if ($locked) {
            $videoSources['sources'] = '';
        }

        return view(
            "member/channel/video/watch",
            [
                'course' => $course,
                'locked' => $locked,
                'video' => $video,
                'videoSources' => $videoSources,
            ]
        );
    }
}
