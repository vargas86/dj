<?php

namespace App\Actions\Web\Guest\Channel;

use App\Models\Channel;
use App\Models\Course;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use Lorisleiva\Actions\Action;

class Listing extends Action
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

        $query = Channel::where('channels.active', true)
            ->join('users', 'users.id', '=', 'channels.user_id')
            ->where('users.deleted_at', null)
            ->addSelect('channels.id as id', 'channels.user_id as user_id', 'channels.cover_image as cover_image', 'channels.pack_id as pack_id', 'channels.active as active', 'channels.additional');
        if (\Auth::check()) {
            $query = $query->where('channels.user_id', '!=', \Auth::user()->id);
        }
        $channels = $query->get();
        return view('guest/channel/listing', [
            'channels' => $channels,
        ]);
    }
}
