<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{   

    public $name;
    public $class;
    public $id;
    public $disabledkey;
    public $label;
    public $options;
    public $selected;
    public $optionkey;
    public $optionvalue;
    /**
     * Create a new component instance.
     * 
     * @return void
     */
    public function __construct($label = "", $name = "", $class="", $id = "", $options = null, $selected = "" , $optionkey = 'id', $optionvalue = 'value' , $disabledkey = "")
    {
        $this->label        = $label;
        $this->class        = $class;
        $this->id           = $id;
        $this->name         = $name;
        $this->selected     = $selected;
        $this->optionkey    = $optionkey;
        $this->optionvalue  = $optionvalue;
        $this->disabledkey  = $disabledkey;
        $this->options  = [];
        if(is_array(json_decode(html_entity_decode($selected)))){
            $this->selected = json_decode(html_entity_decode($selected));
        }
        if($options != null){
            $this->options  = json_decode(html_entity_decode($options),true);
        }
    }

    public function typeClass(){
        return $this->class;
    }

    public function isSelected($option)
    {
        if(is_array($this->selected)){
            return in_array($option, $this->selected);
        }else{
            return $option == $this->selected;
        }
    }

    public function selectedValue($option)
    {
        if(is_array($this->selected)){
            return implode(',', $this->selected);
        }else{
            return $this->selected;
        }
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
