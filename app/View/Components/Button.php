<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $class;
    public $type;
    public $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = null, $type, $label)
    {
        $this->class = $class;
        $this->type = $type;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.button');
    }
}
