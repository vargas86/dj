<?php

namespace App\Actions\Web\Guest\Course;

use App\Models\Channel;
use App\Models\Course;
use App\Models\Gallery;
use App\Models\Member;
use App\Models\Section;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use DB;
use Exception;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class View extends Action
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
    public function handle(Request $request, $course_slug)
    {
        // $course = Course::where('slug', $slug)->first();
        // // dd($course->videos);
        // return view("guest/course/view", [
        //     'course' => $course,
        // ]);

        try {
            $course = Course::where('slug', '=', $course_slug)->first();
            if (!$course) abort(404);
            $video = DB::table('courses')
                ->select('videos.id', 'videos.title')
                ->addSelect('section.title as section_title', 'section.description as section_description')
                ->join('sections', 'sections.course_id', '=', 'courses.id')
                ->join('videos', 'videos.section_id', '=', 'sections.id')
                ->join('sections as section', 'section.id', '=', 'videos.section_id')
                ->where('courses.id', $course->id)
                ->orderBy('videos.order')->orderBy('sections.order')
                ->first();
            $instructor = User::find($course->user_id);
            $subscribed = \Auth::check() && Subscription::where('user_id', $instructor->id)->where('subscriber_id', \Auth::user()->id)->first() ? true : false;
            $channel_id = ($channel = Channel::where('user_id', $instructor->id)->first()) ? $channel->id : null;
            $sections = Section::where('course_id', $course->id)->get();
            // dd($video_object);
        } catch (Exception $e) {
            // dd($e);
        }
        dd([
            'video' => $video,
            'course' => $course,
            'sections' => $sections,
            'channel' => $channel_id,
            'subscribed' => $subscribed,
            'instructor' => $instructor,
        ]);
        return view('guest/course/view')->with([
            'video' => $video,
            'course' => $course,
            'sections' => $sections,
            'channel' => $channel_id,
            'subscribed' => $subscribed,
            'instructor' => $instructor,
        ]);
    }
}
