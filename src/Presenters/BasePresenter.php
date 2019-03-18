<?php namespace Laraplus\Form\Presenters;

use Laraplus\Form\Fields\Close;
use Laraplus\Form\Fields\Base\Element;
use Laraplus\Form\Contracts\FormPresenter;
use Laraplus\Form\Form;
use Laraplus\Form\Helpers\RendersAttributes;

abstract class BasePresenter implements FormPresenter
{
    use RendersAttributes;

    /**
     * @var string
     */
    protected $styleName;

    /**
     * @var array
     */
    protected $style;

    /**
     * @var Element
     */
    protected $element;

    /**
     * @var Form
     */
    protected $form;

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
     * @var bool
     */
    protected $forcedClass;

    /**
     * @param Element $element
     */
    public function setElement(Element $element)
    {
        $this->element = $element;
        $this->form = $element->open->form;
        $this->name = $element->name;
        $this->help = $element->help;
        $this->label = $element->label;
        $this->error = $element->error;
        $this->prefix = $element->prefix;
        $this->suffix = $element->suffix;
        $this->multiple = $element->multiple;
        $this->attributes = $element->attributes;
        $this->forcedClass = $element->forcedClass;
        $this->groupAttributes = $element->groupAttributes;
    }

    /**
     * @return Element
     */
    public function getElement()
    {
        return $this->element;
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
     * @param string $styleName
     * @return mixed|void
     */
    public function setStyleName($styleName)
    {
        $this->styleName = $styleName;
    }

    /**
     * @return array
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @return string
     */
    public function getStyleName()
    {
        return $this->styleName;
    }

    /**
     * @param Close $close
     * @return string
     */
    public function renderClosingTag(Close $close)
    {
        return '</form>';
    }

    /**
     * @return bool
     */
    public function isSubmitted()
    {
        return $this->element->open->isSubmitted();
    }

    /**
     * @return bool
     */
    public function hasSuccessStatus()
    {
        return !empty($this->style['success-status']) && $this->isSubmitted() && $this->element->getValue();
    }
}