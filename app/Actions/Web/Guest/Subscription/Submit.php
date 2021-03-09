<?php

namespace App\Actions\Web\Guest\Subscription;

use App\Models\Channel;
use App\Models\Subscription;
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
    public function handle($channel)
    {
        try {
            
        } catch (Exception $e) {
            return redirect(route('channel.course', ['channel' => $channel]))->withErrors($e->getMessage());
        }
        return redirect(route('channel.course', ['channel' => $channel]));
    }
}
