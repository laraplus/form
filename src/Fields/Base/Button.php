<?php namespace Laraplus\Form\Fields\Base;

abstract class Button extends Element
{
    protected $text;

    /**
     * Initialize field settings
     */
    protected function init()
    {
        parent::init();

        $this->attributes['type'] = 'button';
    }

    /**
     * @param string $text
     * @return $this
     */
    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param $property
     * @return string
     */
    public function __get($property)
    {
        if($property == 'text') {
            return $this->text;
        }

        if($property == 'type') {
            return $this->attributes['type'];
        }

        return parent::__get($property);
    }
}