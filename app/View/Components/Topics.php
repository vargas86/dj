<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Topics extends Component
{

    public $parent;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($parent = null)
    {
        //
        $this->parent = $parent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $topics = \App\Models\Topic::where('disabled', 0)->where('topic_id', $this->parent)->get();
        return view('components.topics', ['topics' => $topics]);
    }
}
