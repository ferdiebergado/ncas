<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $headerClass;
    public $titleClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = null, $headerClass = null, $titleClass = null)
    {
        $this->title = $title;
        $this->headerClass = $headerClass;
        $this->titleClass = $titleClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card');
    }
}
