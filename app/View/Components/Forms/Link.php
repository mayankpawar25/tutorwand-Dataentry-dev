<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Link extends Component
{
    /**
     * The input class.
     *
     * @var string
     */
    public $class;

    /**
     * The input id.
     *
     * @var string
     */
    public $id;

    /**
     * The input href.
     *
     * @var string
     */
    public $href;

    /**
     * The input attributes.
     *
     * @var string
     */
    public $attributes;

    public function __construct($id="", $class="", $href="", $attributes="")
    {
        $this->id = $id;
        $this->class = $class;
        $this->href = $href;
        $this->attributes = $attributes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.link');
    }
}
