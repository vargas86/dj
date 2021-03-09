<?php

namespace App\Actions\Web\Guest\Channel\About;

use App\Models\Channel;
use DB;
use App\Models\Course;
use App\Models\Subscription;
use App\Models\User;
use Lorisleiva\Actions\Action;
use Composer\DependencyResolver\Request;

class Courses extends Action
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
    public function handle($channel)
    {
        $channelSubscribe = Channel::find($channel);
        if (!$channelSubscribe)
            abort(404);

        $user = $channelSubscribe->user;
        $courses = Course::where('courses.published', true)
            ->where('courses.user_id', $user->id)
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
            ->addSelect('courses.id as id','courses.slug as slug', 'courses.thumbnail as thumbnail', 'courses.title as title', 'courses.description as description')
            ->paginate(6);
        // dd($courses->items());
        $isSubscriber = 0;
        if (\Auth::check())
            $isSubscriber = Subscription::where('channel_id', $channel)->where('actif', true)->where('subscriber_id', \Auth::user()->id)->count() > 0 ? true : false;

        $subscribersCount = Subscription::where('user_id', $channelSubscribe->user_id)->where('actif', true)->count();


        return view("guest/channel/channel_cours", [
            'courses' => $courses,
            'user' => $user,
            'isSubscriber' => $isSubscriber,
            'subscribersCount' => $channelSubscribe->SubscriptionsCount
        ]);
    }
}
