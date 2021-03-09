<?php

namespace App\Helpers;

use App\Models\Channel;
use App\Models\Live;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Subscriptions
{
    public static function instance()
    {
        return new Subscriptions();
    }

    public function list()
    {
        if (!auth()->check()) return null;
        $subscriptions = Subscription::where('subscriptions.subscriber_id', auth()->user()->id)
            ->where('subscriptions.actif', true)
            ->where(function ($query) {
                $query->where('subscriptions.end', '>', date('Y-m-d h:i:s'))
                    ->orWhere('subscriptions.end', null);
            })
            ->join('users', 'users.id', '=', 'subscriptions.user_id')
            ->whereNull('users.deleted_at')
            ->join('channels', 'channels.user_id', '=', 'users.id')
            ->leftJoin('lives', 'lives.user_id', '=', 'users.id')
            ->leftJoin(
                DB::raw('(select l.user_id, max(l.created_at) as latest from lives l group by l.user_id) as r'),
                function ($join) {
                    $join->on('lives.created_at', '=', 'r.latest')
                        ->whereColumn('lives.user_id', 'r.user_id');
                }
            )->orderBy('lives.live', 'DESC')
            ->addSelect(
                'subscriptions.id',
                'users.firstname',
                'users.lastname',
                'users.avatar',
                'users.id as user_id',
                'channels.id as channel_id',
                'lives.slug as live_slug'
            )
            ->get();
        return $subscriptions;
    }

    public function isLive($user_id)
    {

        $user = User::find($user_id);
        // 
        if ($user->isLive) {
            return true;
        }
        return false;
    }

    public function subscribers(){
        return Subscription::where('subscriptions.user_id', auth()->user()->id)
        ->where(function ($query) {
            $query->where('subscriptions.end', '>', date('Y-m-d h:i:s'))
                ->orWhere('subscriptions.end', null);
        })
        ->where('subscriptions.actif', true)
        ->addSelect('subscriptions.subscriber_id')
        ->get()
        ->toArray()
        ;
    }
}
