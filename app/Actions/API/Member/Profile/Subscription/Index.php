<?php

namespace App\Actions\API\Member\Profile\Subscription;

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
            $subscriptions = Subscription::where('subscriber_id', \Auth::user()->id)->paginate(10);
            return response()->json([
                'subscriptions' => $subscriptions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([], 422);
        }
    }
}
