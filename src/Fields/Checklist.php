<?php namespace Laraplus\Form\Fields;

class Checklist extends Select
{
    /**
     * @var bool
     */
    protected $inline;

    /**
     * @var array
     */
    protected $optionLabelAttributes = [];

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
     * @param $key
     * @param $name
     * @param $value
     * @return $this
     */
    public function optionLabelAttribute($key, $name, $value)
    {
        if (!isset($this->optionLabelAttributes[$key])) {
            $this->optionLabelAttributes[$key] = [];
        }

        $this->optionLabelAttributes[$key][$name] = $value;

        return $this;
    }

    /**
     * Alias for optionAttribute()
     *
     * @param $key
     * @param $name
     * @param $value
     * @return Select
     */
    public function optionLabelAttr($key, $name, $value)
    {
        return $this->optionLabelAttribute($key, $name, $value);
    }

    /**
     * @param array $attributes
     * @return Select
     */
    public function optionLabelAttributes(array $attributes)
    {
        foreach($attributes as $key => $attrs) {
            foreach((array)$attrs as $name => $value) {
                $this->optionLabelAttribute($key, $name, $value);
            }
        }

        return $this;
    }

    /**
     * Alias For optionAttributes()
     *
     * @param array $attributes
     * @return Select
     */
    public function optionLabelAttrs(array $attributes)
    {
        return $this->optionLabelAttributes($attributes);
    }

    /**
     * @return array
     */
    public function render()
    {
        $items = [];
        $attributes = $this->attributes;
        unset($attributes['id']);
        unset($attributes['name']);

        foreach($this->options as $key => $value)
        {
            $this->optionAttribute($key, 'value', $key);
            $this->optionAttribute($key, 'type', $this->multiple ? 'checkbox' : 'radio');
            $this->optionAttribute($key, 'name', $this->multiple ? $this->name . "[]" : $this->name);

            $checked = in_array($key, (array) $this->getValue()) ? ' checked' : '';

            $items[$key] = '<input' . $this->renderAttributes($attributes) .
                                  $this->renderAttributes($this->optionAttributes[$key]) .
                                  $checked .
                       ' /> ' . $value;
        }

        return $items;
    }

    public function renderLabelAttributes ($key) {
        if (isset ($this->optionLabelAttributes[$key])) {
            return $this->renderAttributes($this->optionLabelAttributes[$key]);
        } else {
            return '';
        }
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