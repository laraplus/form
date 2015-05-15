<?php namespace Laraplus\Form\Presenters;

use Laraplus\Form\Fields\Base\Element;
use Laraplus\Form\Contracts\FormPresenter;
use Laraplus\Form\Helpers\RendersAttributes;

abstract class BasePresenter implements FormPresenter
{
    use RendersAttributes;

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
     * @var
     */
    protected $attributes;

    /**
     * @var
     */
    protected $groupAttributes;

    /**
     * @param Element $element
     */
    public function setElement(Element $element)
    {
        $this->element = $element;
        $this->name = $element->name;
        $this->help = $element->help;
        $this->label = $element->label;
        $this->error = $element->error;
        $this->prefix = $element->prefix;
        $this->suffix = $element->suffix;
        $this->attributes = $element->attributes;
        $this->groupAttributes = $element->groupAttributes;
    }
}