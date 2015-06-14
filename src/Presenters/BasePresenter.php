<?php namespace Laraplus\Form\Presenters;

use Laraplus\Form\Fields\Close;
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
    protected $multiple;

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
        $this->multiple = $element->multiple;
        $this->attributes = $element->attributes;
        $this->groupAttributes = $element->groupAttributes;
    }

    /**
     * @param array $style
     * @return mixed|void
     */
    public function setStyle(array $style)
    {
        $this->style = $style;
    }

    /**
     * @param Close $close
     * @return string
     */
    public function renderClosingTag(Close $close)
    {
        return '</form>';
    }
}