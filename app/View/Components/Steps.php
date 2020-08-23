<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Steps extends Component
{
    public $steps;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $steps)
    {
        $this->steps = $steps;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.steps');
    }
}
