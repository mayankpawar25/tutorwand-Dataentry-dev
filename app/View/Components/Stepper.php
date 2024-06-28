<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Stepper extends Component
{
    public $stepperData;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($stepperData)
    {
        //
        $this->stepperData = json_decode(html_entity_decode($stepperData), true);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.stepper');
    }
}
