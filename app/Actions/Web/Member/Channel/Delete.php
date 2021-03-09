<?php

namespace App\Actions\Web\Member\Channel;

use App\Models\Channel;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Action;

class Delete extends Action
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
        $channel = Channel::findOrFail(\Auth::user()->channel()->id);
        if ($channel->cover_image && str_contains($channel->cover_image , 'amazonaws')) {
            $arr = explode('/', $channel->cover_image);
            $file_name = $arr[sizeof($arr) - 1];
            $folder = $arr[sizeof($arr) - 2];
            Storage::disk('s3')->delete("/" . $folder . "/" . $file_name);
        }
        $channel->delete();
        return redirect(route("profile"));
    }
}
