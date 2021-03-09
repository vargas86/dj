<?php

namespace App\Actions\Web\Guest\Topic;

use Lorisleiva\Actions\Action;
use App\Models\Topic;
use App\Models\Video;

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
    public function handle($path)
    {
        $path = explode('/', $path);
        $slug = end($path);
        $topic = Topic::where('slug', $slug)->where('disabled', false)->first();
        if (!$topic) abort(404);
        $topics = Topic::where('topic_id', $topic->id)->get('id')->toArray();
        foreach ($topics as $key => $value) {
            $topics[$key] = $value['id'];
        }
        array_push($topics, $topic->id);
        $query = Video::whereIn('videos.topic_id', $topics);
        if (request()->get('type')) $query->where('videos.free', true);
        if (request()->get('subscriptions')) {
            $query->join('subscriptions', 'subscriptions.user_id', '=', 'videos.user_id')
            ->where('subscriptions.subscriber_id', auth()->user()->id)
            ->where('subscriptions.actif', true)
            ->where(function ($query) {
                $query->where('subscriptions.end', '>', date('Y-m-d h:i:s'))
                ->orWhere('subscriptions.end', null);
            })
            ->get();
        }
        $query->where('videos.published', true);
        $query->where('videos.course_id', null);
        $query->where('videos.section_id', null);
        if (\Auth::check()) $query->where('videos.user_id', '<>', \Auth::user()->id);
        $videos = $query->paginate(12);
        if (request()->get('page')) {
            return view('/topic/topic_pagination', ['videos' => $videos]);
        }
        
        return view('/topic/topic', ['topic' => $topic, 'videos' => $videos]);
    }
}
