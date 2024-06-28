<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{

    /**
     * The input type.
     *
     * @var string
     */
    public $type;

    /**
     * The input value.
     *
     * @var string
     */
    public $value;

    /**
     * The input class.
     *
     * @var string
     */
    public $class;

    /**
     * The input name.
     *
     * @var string
     */
    public $name;

    /**
     * The input id.
     *
     * @var string
     */
    public $id;

    /**
     * The input attributes.
     *
     * @var string
     */
    public $attributes;

    /**
     * The input placeholder.
     *
     * @var string
     */
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $name="", $class="", $id="", $value ="", $attributes="", $placeholder ="")
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->class = $class;
        $this->attributes = $attributes;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
