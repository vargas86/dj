<?php

namespace App\Actions\Web\Member\Channel\Video;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class Listing extends Action
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
        $videos = Video::where('videos.user_id', \Auth::user()->id)
        ->join('users', 'users.id', '=', 'videos.user_id')
        ->where('users.deleted_at', null)
        ->where('videos.course_id' , null)->paginate(10);
        return view(
            "member/channel/video/listing",
            ['videos' => $videos,]
        );
    }
}
