<?php

namespace App\Actions\Web\Profile;

use App\Models\Video;
use App\Models\Gallery;
use App\Models\Subscription;
use Illuminate\Http\Request;
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
    public function handle(Request $request)
    {
        //this return count of subscription for users profil
        $totalSubscription = Subscription::where('user_id', \Auth::user()->id)->count();
        //this return count of videos load by user
        $nomberVideoUpload = Video::where('user_id', \Auth::user()->id)->count();


        return view('profile.details', [
            'user' => \Auth::user(),
            'totalSubscription' => $totalSubscription,
            'nomberVideoUpload' => $nomberVideoUpload,
        ]);
    }
}
