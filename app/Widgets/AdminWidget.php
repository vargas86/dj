<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class AdminWidget extends AbstractWidget
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
        $count = \App\Models\Admin::count();
        $string = 'Admins';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-group',
            'title'  => "{$count} {$string}",
            'text'   => 'You have '.$count.' registered admins. Click the button below to view all admins.',
            'button' => [
                'text' => 'Admins',
                'link' => '#',
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
