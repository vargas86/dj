<?php

namespace App\Actions\Web\Member\Channel\Course;

use Exception;
use Validator;
use App\Models\Pack;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Channel;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Storage;

class Remove extends Action
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
    public function handle(Request $request, $slug)
    {
        $course = Course::where('slug', $slug)->first();
        try {
            if ($course->thumbnail) {
                $arr = explode('/', $course->thumbnail);
                $file_name = $arr[sizeof($arr) - 1];
                $folder = $arr[sizeof($arr) - 2];
                Storage::disk('s3')->delete('/' . $folder . '/' . $file_name);
            }
            $course->delete();
        } catch (Exception $e) {
            return redirect(route('channel'))
                ->withErrors([
                    'Operation failed.'
                    // $e->getMessage()
                ]);
        }
        return redirect(route('channel'));
    }
}
