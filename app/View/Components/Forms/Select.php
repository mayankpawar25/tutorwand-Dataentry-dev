<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Select extends Component
{   

    /**
     * The Select Input type.
     *
     * @var string
     */
    public $type;

    /**
     * The Select Input value.
     *
     * @var string
     */
    public $value;

    /**
     * The Select Input class.
     *
     * @var string
     */
    public $class;

    /**
     * The Select Input name.
     *
     * @var string
     */
    public $name;

    /**
     * The Select Input id.
     *
     * @var string
     */
    public $id;

    /**
     * The Select Input attributes.
     *
     * @var string
     */
    public $attributes;

    /**
     * The Select Input label.
     *
     * @var string
     */
    public $label;

    public $options;
    public $keyValue;
    public $textValue;
    public $selected;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($options = [], $value ="", $class="", $name="", $id="",  $attributes="", $label ="", $keyValue="", $textValue="", $selected="")
    {
        $this->id       = $id;
        $this->name     = $name;
        $this->value    = $value;
        $this->class    = $class;
        $this->label    = $label;
        $this->options  = $options;
        $this->attributes  = $attributes;
        $this->keyValue    = $keyValue;
        $this->textValue   = $textValue;
        $this->selected    = $selected;
    }

    /**
     * Determine if the given option is the currently selected option.
     *
     * @param  string  $option
     * @return bool
     */
    public function isSelected($option)
    {
        return $option === $this->selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.select');
    }
}
