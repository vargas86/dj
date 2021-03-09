<?php

namespace App\Actions\API\Guest\Channel;

use App\Models\Channel;
use App\Models\Subscription;
use Lorisleiva\Actions\Action;

class Index extends Action
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
    public function handle()
    {
        try {
            $query = Channel::where('active', true);
            if (auth()->check()) $query->where('user_id', '<>', auth()->user()->id);
            $channels = $query->paginate(10)->toArray();
            return response()->json(['channels' => $channels], 200);
        } catch (\Throwable $e) {
            return response()->json([], 422);
        }
    }
}
