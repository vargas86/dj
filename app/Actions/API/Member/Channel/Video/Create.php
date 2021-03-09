<?php

namespace App\Actions\API\Member\Channel\Video;

use App\Models\Course;
use App\Models\Section;
use App\Models\Video;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Action;

class Create extends Action
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
    public function handle(Request $request, $course_slug = null, $section_id = null)
    {
        try {

            // Validation
            $validator = Validator::make($request->all(), [
                'video' => ['required', 'mimes:mp4,avi,mov,mkv,flv,wmv', 'max:50000000']
            ]);
            if ($validator->fails()) {
                return response()->json([$validator->errors()->all()], 422);
            }

            // copy file to storage
            $file = $request->video;
            $video_name = 'original_' . \Auth::user()->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = storage_path('app/public/videos/');
            $file->move($path, $video_name);
            // $chmod = chmod($path . $video_name, 0777);
            // if (!$chmod) return response()->json(['Chmod returned false.'], 422);
            DB::beginTransaction();

            //create video object
            $video = Video::create([
                'filename' => $video_name,
                'user_id' => \Auth::user()->id,
            ]);
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_';
            $result = '';
            for ($i = 0; $i < 11; $i++) {
                $result .= $characters[mt_rand(0, 63)];
            }
            $statement = DB::select("show table status like 'videos'");
            $result .= $statement[0]->Auto_increment;
            $video->slug = $result;
            $video->status = 'w';
            $video->published = false;
            $video->channel_id = \Auth::user()->channel()->id;
            if ($course_slug && $section_id) {
                if (($section = Section::find($section_id)) && ($course = Course::where('slug', $course_slug)->first())) {
                    $video->section_id = $section->id;
                    $video->course_id = $course->id;
                } else {
                    return response()->json([], 422);
                }
            }
            $video->save();
            $response = Http::timeout(5)->withOptions([
                'verify' => false,
            ])->post(
                env('CONVERT_URL'),
                [
                    'video_id' => $video->id,
                    'filename' => $video->filename,
                ]
            );
            DB::commit();
            return response()->json(["video_slug" => $video->slug], 200);
        } catch (\Exception $e) {
            return response()->json([], 422);
        }
    }
}
