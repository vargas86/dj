<?php

namespace App\Actions\Web\Guest\Live\Chat;

use App\Models\Chat;
use App\Models\Live;
use App\Models\Topic;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
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
    public function handle(Request $request, $live_slug)
    {
        try {
            $live = Live::where('slug', $live_slug)->first();
            if ($request->get('message') && $request->get('user_id')) {
                $chat = Chat::create([
                    'message' => $request->get('message'),
                    'user_id' => $request->get('user_id'),
                    'live_id' => $live->id,
                ]);
                if ($live->start) {
                    $timing = gmdate('H:i:s', $chat->created_at->diffInSeconds($live->start));
                    $chat->timing = $timing;
                }
                return response()->json(['message_id' => $chat->id], 200);
            }
        } catch (\Exception $e) {
            return response()->json([], 422);
        }
    }
}
