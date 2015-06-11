<?php namespace Laraplus\Form\Presenters;

use Laraplus\Form\Fields\Base\Element;
use Laraplus\Form\Contracts\FormPresenter;
use Laraplus\Form\Helpers\RendersAttributes;

abstract class BasePresenter implements FormPresenter
{

    use RendersAttributes;

    /**
     * @var array
     */
    protected $style;

    /**
     * @var Element
     */
    protected $element;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $help;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $error;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $groupAttributes;

    /**
     * @var bool
     */
    protected $raw;

    /**
     * @var bool
     */
    protected $multiple;

    /**
     * @param Element $element
     * @return Element
     */
    public function decorate(Element $element)
    {
        $this->element = $element;
        $this->raw = $element->raw;
        $this->name = $element->name;
        $this->help = $element->help;
        $this->label = $element->label;
        $this->error = $element->error;
        $this->prefix = $element->prefix;
        $this->suffix = $element->suffix;
        $this->multiple = $element->multiple;
        $this->attributes = $element->attributes;
        $this->groupAttributes = $element->groupAttributes;

        return $element;
    }

    /**
     * @param array $style
     * @return mixed|void
     */
    public function style(array $style)
    {
        $this->style = $style;
    }
}