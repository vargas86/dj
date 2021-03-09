<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationsHelper
{
    public static function instance()
    {
        return new NotificationsHelper();
    }

    public function list($user_id)
    {
        $notifications = [];
        if (auth()->check()) {
            $notifications = Notification::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->orderBy('viewed', 'ASC')->paginate(10);
        }
        return $notifications;
    }
    public function count($user_id)
    {
        $notifications = [];
        if (auth()->check()) {
            $notifications = Notification::where('user_id', auth()->user()->id)->where('viewed', false)->count();
        }
        return $notifications > 10 ? '10+' : $notifications;
    }
}
