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

    public function renderField()
    {
        $this->attributes['value'] = $this->getValue();

        $attributes = $this->renderAttributes();

        return '<input ' . $attributes . ' />';
    }
}