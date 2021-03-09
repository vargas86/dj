<?php

namespace App\Actions\API\Guest\Video;

use App\Models\Course;
use App\Models\Pack;
use App\Models\Section;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use App\Models\Videoquality;
use Lorisleiva\Actions\Action;
use Illuminate\Http\Request;

class Details extends Action
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
    public function handle(Request $request, $video_slug, $course_slug, $section_id)
    {
        try {
            $video = Video::where('slug', $video_slug)->where('published', true)->first();
            if (!$video) return response()->json([], 404);

            $subscription = Subscription::where('subscriber_id', auth()->user()->id)->where('user_id', $video->user_id)->where('actif', true)->first();
            $teacher = User::find($video->user_id);
            $subscribers = Subscription::where('user_id', $teacher->id)->where('actif', true)->count();
            $pack = Pack::where('user_id', $teacher->id)->first()->toArray();
            $video_qualities = Videoquality::where('video_id')->get()->toArray();
            $data = [
                'video' => [
                    "id" => $video->id,
                    "free" => $video->free,
                    "published" => $video->published,
                    'description' => $video->description,
                    "duration" => null,
                    "filename" => null,
                    "status" => $video->status,
                    'title' => $video->title,
                    "slug" => $video->slug,
                    "language" => $video->language,
                    'thumbnail' => $video->thumbnail,
                    'miniature_thumbnail' => $video->miniature_thumbnail,
                ],
                'videoqualities' => null,
                'teacher' => [
                    'firstname' => $teacher->firstname,
                    'lastname' => $teacher->lastname,
                    'subscribers' => $subscribers,
                ],
                'pack' => null,
            ];
            if ($section_id && $course_slug) {
                $section = Section::find($section_id)->toArray();
                $course = Course::where('slug', $course_slug)->first()->toArray();
                $data['section'] = $section;
                $data['course'] = $course;
            }
            if ($video->free) {
                if ($video->status === 'e') {
                    $data['videoqualities'] = $video_qualities;
                } else {
                    $data['video']['filename'] = $video->filename;
                }
                return response()->json($data, 200);
            } elseif (auth()->check()) {
                if ($subscription) {
                    if ($video->status === 'e') {
                        $data['videoqualities'] = $video_qualities;
                    } else {
                        $data['video']['filename'] = $video->filename;
                    }
                } else {
                    $data['pack'] = $pack;
                }
            } else {
                $data['pack'] = $pack;
            }
            return response()->json([$data], 200);
        } catch (\Throwable $e) {
            return response()->json([], 422);
        }
    }
}
