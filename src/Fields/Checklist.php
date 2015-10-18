<?php namespace Laraplus\Form\Fields;

class Checklist extends Select
{
    /**
     * @var bool
     */
    protected $inline;

    /**
     * @return $this
     */
    public function inline()
    {
        $this->inline = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function stacked()
    {
        $this->inline = false;

        return $this;
    }

    /**
     * @return array
     */
    public function render()
    {
        $items = [];

        foreach($this->options as $key => $value)
        {
            $this->optionAttribute($key, 'value', $key);
            $this->optionAttribute($key, 'type', $this->multiple ? 'checkbox' : 'radio');
            $this->optionAttribute($key, 'name', $this->multiple ? $this->name . "[$key]" : $this->name);

            $items[] = '<input' . $this->renderAttributes($this->optionAttributes[$key]) . ' /> ' . $value;
        }

        return $items;
    }

    /**
     * @param $property
     * @return bool|string
     */
    public function __get($property)
    {
        if($property == 'inline') {
            return $this->inline;
        }

        return parent::__get($property);
    }
}