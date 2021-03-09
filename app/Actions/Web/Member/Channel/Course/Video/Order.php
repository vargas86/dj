<?php

namespace App\Actions\Web\Member\Channel\Course\Video;

use Exception;
use App\Models\Video;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Order extends Action
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
        $section_id = $request->input('section_id');
        $video_id = $request->input('video_id');
        $order = $request->input('order');
        try {
            $video = Video::find($video_id);
            $video->order = $order;
            $video->section_id = $section_id;
            $video->save();
        } catch (Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => null,
            ], 200);
        }
        return new JsonResponse([
            'status' => 'success',
            'message' => null,
            'test' => $request
        ], 200);
    }
}
