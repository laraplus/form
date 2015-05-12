<?php namespace Laraplus\Form\Fields\Base;

abstract class Element
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $name = null;

    /**
     * @var string|array
     */
    protected $value = null;

    /**
     * @var \Laraplus\Form\Form
     */
    protected $form;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function attribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function data($name, $value)
    {
        $this->attributes['data-' . $name] = $value;

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->attributes['class'] = $class;

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function addClass($class)
    {
        $this->attributes['class'] = trim($this->attributes['class'] . ' ' . $class);

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

    /**
     * @return string
     */
    public function renderAttributes()
    {
        $attributes = [];

        foreach($this->attributes as $key=>$value) {
            $attributes[] = $key . '="' . $value . '"';
        }

        return implode(' ', $attributes);
    }

    /**
     * @return string
     */
    public abstract function render();
}