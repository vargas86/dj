<?php

namespace App\Actions\API\Member\Channel\Course\Section;

use App\Models\Section;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use stdClass;

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
        $order = $request->input('order');
        try {
            $section = Section::find($section_id);
            $section->order = $order;
            $section->save();
        } catch (Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => null,
            ], 200);
        }
        return new JsonResponse([
            'status' => 'success',
            'message' => null,
        ], 200);
    }
}
