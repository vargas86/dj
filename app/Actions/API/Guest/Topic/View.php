<?php

namespace App\Actions\API\Guest\Topic;

use Lorisleiva\Actions\Action;
use App\Models\Topic;

class View extends Action
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
    public function handle($path)
    {
        $path = explode('/', $path);
        $slug = end($path);
        $topic = Topic::where('slug', $slug)->first();
        if (!$topic) return response()->json([], 404);
        return response()->json(['topic' => $topic], 200);
    }
}
