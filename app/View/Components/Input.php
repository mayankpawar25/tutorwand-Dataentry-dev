<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $type;
    public $name;
    public $class;
    public $id;
    public $disabledkey;

    public function __construct($type, $name, $class, $id = "", $disabledkey = "") {
        $this->type         = $type;
        $this->name         = $name;
        $this->class        = $class;
        $this->id           = $id;
        $this->disabledkey  = $disabledkey;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.input');
    }
}
