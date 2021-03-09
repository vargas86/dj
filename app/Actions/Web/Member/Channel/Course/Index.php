<?php

namespace App\Actions\Web\Member\Channel\Course;

use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
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
    public function handle(Request $request)
    {
        $courses = Course::where('user_id', \Auth::user()->id)->paginate(5);

        if (!sizeof(\Auth::user()->channels)) {
            return redirect(route('channel.active1'));
        }

        return view("member/channel/course/list", [
            'courses' => $courses,
        ]);
    }
}
