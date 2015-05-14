<?php namespace Laraplus\Form\Fields\Base;

abstract class Input extends Element
{
    public function type($type)
    {
        $this->attributes['type'] = $type;
    }

    public function placeholder($placeholder)
    {
        $this->attributes['placeholder'] = $placeholder;
    }

    public function render()
    {
        return '<input ' . $this->renderAttributes() . ' />';
    }
}