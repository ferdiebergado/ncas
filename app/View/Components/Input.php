<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $label;
    public $id;
    public $class;
    public $type;
    public $placeholder;
    public $value;
    public $required;
    public $autofocus;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $id = null, $class = null, $type = 'text', $placeholder, $value = null, $required = null, $autofocus = null)
    {
        $this->label = $label;
        $this->id = $id;
        $this->classes = $class;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->value = $value;
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
        return view('components.input');
    }
}
