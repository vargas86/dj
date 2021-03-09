<?php

namespace App\Actions\API\Guest\Instructors;

use App\Models\Channel;
use App\Models\Course;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use Lorisleiva\Actions\Action;

class Instructor extends Action
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
        $channels = Channel::whereActive(true)->get();
        $countCourses = $countVideos = [];
        foreach ($channels as $index => $channel) {
            $subscribersCount[$index] = Subscription::where('user_id', $channel->user_id)->count();
            $countCourses[$index] = Course::where('user_id', $channel->user_id)->count();
            $countVideos[$index] = Video::where('user_id', $channel->user_id)->where('course_id', null)->count();
        }

        return response()->json([
            'channels' => $channels,
            'subscribersCount' => $subscribersCount,
            'countCourses' => $countCourses,
            'countVideos' => $countVideos,
        ], 200);
    }
}
