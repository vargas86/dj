<?php

namespace App\Actions\Web\Member\Notification;

use App\Models\Notification;
use Validator;
use Exception;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

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
            if ($request->get('user_id') && $request->get('title') && $request->get('message') && $request->get('target_url')) {
                $notification = new Notification();
                $notification->user_id = $request->get('user_id');
                $notification->title = $request->get('title');
                $notification->viewed = false;
                $notification->message = $request->get('message');
                $notification->target_url = $request->get('target_url');
                $notification->save();
                return response()->json(['n_id' => $notification->id], 200);
            }
        } catch (Exception $e) {
            return response()->json([$e], 422);
        }
        return response()->json(['sadds'], 422);
    }
}
