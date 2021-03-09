<?php

namespace App\Actions\Web\Member\Profile;

use App\Models\User;
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
        if (str_contains(auth()->user()->avatar, 'amazonaws')) {
            $arr = explode('/', auth()->user()->avatar);
            $file_name = $arr[sizeof($arr) - 1];
            $folder = $arr[sizeof($arr) - 2];
            Storage::disk('s3')->delete("/" . $folder . "/" . $file_name);
        }
        auth()->user()->delete();
        return redirect(route("home"));
    }
}
