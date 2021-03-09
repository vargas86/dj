<?php

namespace App\Actions\Web\Member\Profile\Subscriptions;

use App\Models\Subscription;
use DB;
use Exception;
use Lorisleiva\Actions\Action;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

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
            $teachers = DB::table('subscriptions')
                ->join('users', 'users.id', '=', 'subscriptions.user_id')
                ->join('channels', 'channels.user_id', '=', 'users.id')
                ->where('subscriptions.subscriber_id', \Auth::user()->id)
                ->addSelect('users.firstname as firstname', 'channels.id as channel_id', 'channels.pack_id as pack_id', 'users.lastname as lastname', 'users.avatar as avatar', 'subscriptions.created_at as created_at', 'subscriptions.updated_at as updated_at', 'subscriptions.actif as actif')
                ->orderBy('actif', 'DESC')
                ->get();
        } catch (Exception $e) {
            return view('member/profile/subscriptions')->with([
                'teachers' => [],
            ]);
        }
        return view('member/profile/subscriptions')->with([
            'teachers' => $teachers,
        ]);
    }
}
