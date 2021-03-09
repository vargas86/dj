<?php

namespace App\Actions\Web\Member\Channel\Video;

use Exception;
use App\Models\Video;
use App\Models\Course;
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
    public function handle(Request $request, $video_slug, $course_slug = null, $section_id = null)
    {
        try {
            $video = Video::where('slug', $video_slug)->first();
            if (!$video)
                abort(404);
            if ($video->thumbnail && str_contains($video->thumbnail, 'amazonaws')) {
                $arr = explode('/', $video->thumbnail);
                $file_name = $arr[sizeof($arr) - 1];
                $folder = $arr[sizeof($arr) - 2];
                Storage::disk('s3')->delete('/' . $folder . '/' . $file_name);
            }
            if ($video->miniature_thumbnail && str_contains($video->miniature_thumbnail, 'amazonaws')) {
                $arr = explode('/', $video->miniature_thumbnail);
                $file_name = $arr[sizeof($arr) - 1];
                $folder = $arr[sizeof($arr) - 2];
                Storage::disk('s3')->delete('/' . $folder . '/' . $file_name);
            }
            if ($video->filename) Storage::disk('public')->delete('/videos/' . $video->filename);
            foreach ($video->videoqualities as $key => $videoquality) {
                $videoquality_name = ($tmp = explode('/', $videoquality->url))[sizeof($tmp) - 1];
                Storage::disk('s3')->delete('/' . $tmp[sizeof($tmp) - 2] . '/' . $videoquality_name);
                $videoquality->delete();
            }
            foreach ($video->comments as $key => $comment) {
                $comment->delete();
            }
            $video->delete();
            if ($course_slug && $section_id) {
                return redirect(route('course.manage', ['course_slug' => $course_slug]));
            }
        } catch (Exception $e) {
            dd($e);
            return redirect(route('video.list'))
                ->withErrors([
                    'Operation failed.'
                ]);
        }
        return redirect(route('video.list'));
    }
}
