<?php namespace Laraplus\Form\Fields\Base;

abstract class Input extends Element
{
    public function type($type)
    {
        $this->attributes['type'] = $type;
    }

    public function render()
    {
        return '<input type="' . $this->attributes['type'] . '" />';
    }
}