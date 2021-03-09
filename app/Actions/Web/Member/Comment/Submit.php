<?php

namespace App\Actions\Web\Member\Comment;

use App\Models\Comment;
use App\Models\Video;
use Image;
use Exception;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Storage;

class Submit extends Action
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
            $comment_content = $request->comment;
            $video_slug = $request->video_slug;
            $video = Video::where('slug', $video_slug)->first();
            $parent_id = ($intval = intval($request->parent_id)) ? $intval : null;
            // dd($parent_id);

            $comment = Comment::create([
                'user_id' => \Auth::user()->id,
                'video_id' => $video->id,
                'parent_id' => $parent_id,
                'text' => $comment_content,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        return response()->json(['id' => $comment->id], 200);
    }
}
