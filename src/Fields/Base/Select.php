<?php namespace Laraplus\Form\Fields\Base;

abstract class Select extends Element
{
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
    public function addOption($key, $value)
    {
        $this->options[$key] = $value;

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
        if(!isset($this->optionAttributes[$key])) {
            $this->optionAttributes[$key] = [];
        }

        $this->optionAttributes[$key][$name] = $value;

        return $this;
    }

    /**
     * @param $key
     * @param $name
     * @param $value
     * @return $this
     */
    public function optionData($key, $name, $value)
    {
        $this->setAttribute($key, 'data-' . $name, $value);

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

        $this->setAttribute($key, 'class', trim($class . ' ' . $value));

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOptionClass($key, $value)
    {
        $this->setAttribute($key, 'class', $value);

        return $this;
    }

}