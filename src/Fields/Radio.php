<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Element;

class Radio extends Checkbox
{
    protected $checked = false;

    /**
     * Initialize field settings
     */
    protected function init()
    {
        parent::init();

        $this->attributes['type'] = 'radio';
        $this->parseNameValue();
    }

    protected function parseNameValue()
    {
        if(! str_contains($this->name, '[')) {
            throw new Exception('Radio button name must be defined as name[value]');
        }

        list($name, $value) = explode('[', $this->name);
        $this->attributes['name'] = $name;
        $this->value = trim($value, ']');
    }
}