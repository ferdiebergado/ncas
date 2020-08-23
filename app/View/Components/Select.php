<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $id;
    public $class;
    public $options;
    public $optionValue;
    public $optionText;
    public $required;
    public $autofocus;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $id, $class = null, $options = null, $optionValue = null, $optionText = null, $required = null, $autofocus = null)
    {
        $this->label = $label;
        $this->id = $id;
        $this->class = $class;
        $this->options = $options;
        $this->optionValue = $optionValue;
        $this->optionText = $optionText;
        $this->required = (bool) $required;
        $this->autofocus = (bool) $autofocus;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.select');
    }
}
