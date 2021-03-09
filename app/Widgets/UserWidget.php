<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class UserWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = \App\Models\Member::count();
        $string = 'Users';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-group',
            'title'  => "{$count} {$string}",
            'text'   => 'You have '.$count.' registered users. Click the button below to view all users.',
            'button' => [
                'text' => 'Users',
                'link' => route('voyager.users.index'),
            ],
            'image' => '/storage/admin/members-bg.jpg',
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return true;
    }
}
