<?php

namespace App\Actions\Web\Guest\Live\Chat;

use App\Models\Chat;
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
    public function handle(Request $request, $live_slug, $message_id)
    {
        $message = Chat::find($message_id);
        if ($message) {
            return view('guest/live/chat', [
                'message' => $message
            ]);
        } else {
            return response()->json([], 404);
        }
    }
}
