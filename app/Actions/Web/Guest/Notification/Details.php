<?php

namespace App\Actions\Web\Guest\Notification;

use App\Models\Notification;
use Lorisleiva\Actions\Action;

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
    public function handle($notification_id)
    {
        try {
            $notification = Notification::find($notification_id);
            if ($notification) {
                $count = Notification::where('user_id', $notification->user_id)->where('viewed', false)->count();
                return response()->json(['html' => view('guest/notification/element', ['notification' => $notification])->render(), 'count' => $count], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([], 422);
        }
        return response()->json([], 422);
    }
}
