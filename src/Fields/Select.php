<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Element;

class Select extends Element
{
    protected $placeholder;

    protected $multiple = false;
    
    protected $options = [];

    protected $optionAttributes = [];

    /**
     * @param array $options
     * @return $this
     */
    public function options($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function prependOption($key, $value)
    {
        $this->options = [$key => $value] + $this->options;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function appendOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }
    
    /**
     * @param string $text
     * @return $this
     */
    public function placeholder($text)
    {
        $this->placeholder = $text;

        return $this;
    }

    /**
     * @return $this
     */
    public function multiple()
    {
        $this->multiple = true;

        return $this;
    }

    /**
     * @param $key
     * @param $name
     * @param $value
     * @return $this
     */
    public function optionAttribute($key, $name, $value)
    {
        if (!isset($this->optionAttributes[$key])) {
            $this->optionAttributes[$key] = [];
        }

        $this->optionAttributes[$key][$name] = $value;

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
    public function optionAttr($key, $name, $value)
    {
        return $this->optionAttribute($key, $name, $value);
    }

    /**
     * @param array $attributes
     * @return Select
     */
    public function optionAttributes(array $attributes)
    {
        foreach($attributes as $key => $attrs) {
            foreach((array)$attrs as $name => $value) {
                $this->optionAttribute($key, $name, $value);
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
    public function optionAttrs(array $attributes)
    {
        return $this->optionAttributes($attributes);
    }

    /**
     * @param $key
     * @param $name
     * @param $value
     * @return $this
     */
    public function optionData($key, $name, $value)
    {
        $this->optionAttribute($key, 'data-' . $name, $value);

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addOptionClass($key, $value)
    {
        $class = isset($this->optionAttributes[$key]['class']) ? $this->optionAttributes[$key]['class'] : '';

        $this->optionAttribute($key, 'class', trim($class . ' ' . $value));

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOptionClass($key, $value)
    {
        $this->optionAttribute($key, 'class', $value);

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $multiple = $this->multiple ? ' multiple' : '';

        $select = '<select' . $this->renderAttributes($this->attributes) . $multiple . '>';

        $select .= $this->renderOptions();

        $select .= '</select>';

        return $select;
    }

    /**
     * @param $key
     * @return bool
     */
    protected function isSelected($key)
    {
        $selectedValue = $this->getValue();

        return in_array($key, (array) $selectedValue);
    }

    /**
     * @return string
     */
    protected function renderOptions()
    {
        $options = '';

        if($this->placeholder) {
            $options .= '<option value="">' . $this->placeholder . '</option>';
        }

        foreach ($this->options as $key => $value) {

            $this->optionAttributes[$key]['value'] = $key;
            $selected = $this->isSelected($key) ? ' selected' : '';
            $attributes = $this->renderAttributes($this->optionAttributes[$key]);

            $options .= '<option' . $attributes . $selected . '>' . $value . '</option>';
        }

        return $options;
    }
}
