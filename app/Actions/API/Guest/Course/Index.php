<?php

namespace App\Actions\API\Guest\Course;

use Exception;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use DB;

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
    public function handle(Request $request)
    {
        try {
            $data = DB::table('users')
                ->join('subscriptions', 'subscriptions.subscriber_id', '=', 'users.id')
                ->join('courses', 'courses.user_id', '=', 'subscriptions.user_id')
                ->join('users as instructor', 'instructor.id', '=', 'courses.user_id')
                ->join('topics', 'topics.id', '=', 'courses.topic_id')
                ->addSelect('courses.slug as course.slug', 'courses.thumbnail as course.thumbnail', 'courses.title as course.title')
                ->addSelect('instructor.firstname as instructor.firstname', 'instructor.lastname as instructor.lastname', 'instructor.avatar as instructor.avatar')
                ->addSelect('topics.title as topic.title', 'topics.abbreviation as topic.abbreviation')
                ->get();
            $data = json_decode(json_encode($data), true);
            $result = [];
            foreach ($data as $item) {
                $result[] = [
                    'topic' => [
                        'title' => $item['topic.title'],
                        'abbreviation' => $item['topic.abbreviation'],
                    ],
                    'instructor' => [
                        'avatar' => $item['instructor.avatar'],
                        'name' => $item['instructor.firstname'] . ' ' . $item['instructor.lastname'],
                    ],
                    'course' => [
                        'thumbnail' => $item['course.thumbnail'],
                        'title' => $item['course.title'],
                        'slug' => $item['course.slug'],
                    ],
                ];
            }
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 422);
        }
        return response()->json(['courses', $result], 200);
    }
}
