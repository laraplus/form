<?php namespace Laraplus\Form\Presenters;

use Laraplus\Form\Fields\Checkbox;
use Laraplus\Form\Fields\Open;
use Laraplus\Form\Fields\Base\Button;

class Bootstrap3Presenter extends BasePresenter
{
    /**
     * @return bool
     */
    protected function isInline()
    {
        return isset($this->style['form']) && strpos($this->style['form'], 'form-inline') !== false;
    }

    /**
     * @return bool
     */
    protected function isHorizontal()
    {
        return isset($this->style['form']) && strpos($this->style['form'], 'form-horizontal') !== false;
    }

    /**
     * @return bool
     */
    protected function isVertical()
    {
        return !$this->isInline() && !$this->isHorizontal();
    }

    /**
     * @return string
     */
    protected function getLabelClass()
    {
        return isset($this->style['label']) ? ' class="' . $this->style['label'] . '"' : '';
    }

    /**
     * @return string
     */
    protected function getGroupClass()
    {
        return 'form-group' . ($this->error ? ' has-error' : '');
    }

    /**
     * @return string
     */
    protected function getElementClass()
    {
        $class = isset($this->style['element']) ? $this->style['element'] : '';

        if((!$this->label || $this->isCheckbox()) && isset($this->style['no_label'])) {
            $class = $this->style['no_label'];
        }

        return isset($this->style['element']) ? ' class="' . $class . '"' : '';
    }

    /**
     * @return string
     */
    public function renderOpeningTag(Open $open)
    {
        if (isset($this->style['form'])) {
            $open->addClass($this->style['form']);
        }

        return '<form' . $this->renderAttributes($open->attributes) . '>';
    }

    /**
     * @param Button $button
     * @return string
     */
    public function renderButton(Button $button)
    {
        $button->addClass('btn');

        return '<button' . $this->renderAttributes($button->attributes) . '>' . $button->text . '</button>';

    }

    /**
     * @return string
     */
    public function renderLabel()
    {
        if (!$this->label || $this->labelShouldBeInline()) {
            return '';
        }

        $class = $this->getLabelClass();

        return '<label for="' . $this->attributes['id'] . '"' . $class . '>' . $this->label . '</label>';
    }

    /**
     * @return string
     */
    public function renderField()
    {
        if(!$this->isButton() && !$this->isCheckbox()) {
            $this->element->addClass('form-control');
        }

        $rendered = $this->element->render();

        if(is_array($rendered)) {
            $isInline = $this->isInline() || $this->element->inline;

            return $isInline ? $this->renderInlineList($rendered) : $this->renderList($rendered);
        }

        return $rendered;
    }

    /**
     * @param array $elements
     * @return string
     */
    protected function renderList($elements)
    {
        $list = '';
        $class = $this->element->multiple ? 'checkbox' : 'radio';

        foreach($elements as $element) {
            $list .= '<div class="' . $class . '"><label>' . $element . '</label></div>';
        }

        return $list;
    }

    /**
     * @param array $elements
     * @return string
     */
    protected function renderInlineList($elements)
    {
        $class = $this->element->multiple ? 'checkbox' : 'radio';
        $list = '<div' . ($this->isVertical() ? ' class="' . $class . '"' : ''). '>';

        foreach($elements as $element) {
            $list .= '<label class="' . $class . '-inline">' . $element . '</label>';
        }

        return $list . '</div>';
    }

    /**
     * @return string
     */
    public function renderError()
    {
        if (!$this->error) {
            return false;
        }

        return '<div class="help-block">' . $this->error . '</div>';
    }

    /**
     * @return string
     */
    public function renderAll()
    {
        $this->element->addGroupClass($this->getGroupClass());
        
        $result = '<div' . $this->renderAttributes($this->element->groupAttributes) . '>';
        $result .= $this->renderElementGroup();
        $result .= '</div>';

        return $result;
    }

    /**
     * @return string
     */
    protected function renderElementGroup()
    {
        if($this->isCheckbox()) return $this->renderCheckbox();

        $result = $this->renderLabel();

        if ($fieldContainer = $this->getElementClass()) {
            $result .= '<div' . $fieldContainer . '>';
        }

        if($this->label && $this->labelShouldBeInline()) {
            $this->element->placeholder($this->label);
        }

        $result .= $this->renderPrefix() . $this->renderField() . $this->renderSuffix();

        if ($fieldContainer) {
            $result .= '</div>';
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function renderCheckbox()
    {
        $field = trim($this->prefix . $this->renderField() . ' ' . $this->label . $this->suffix);

        $label = '<label for="' . $this->attributes['id'] . '">' . $field .  '</label>';

        if(!$this->isHorizontal()) {
            return '<div class="checkbox">' . $label . '</div>';
        }

        return '<div'.$this->getElementClass().'><div class="checkbox">' . $label . '</div></div>';
    }

    /**
     * @return string
     */
    protected function renderPrefix()
    {
        $result = '';

        if($this->prefix || $this->suffix) {
            $result .= '<div class="input-group">';
        }

        if($this->prefix) {
            $result .= '<div class="input-group-addon">' . $this->prefix . '</div>';
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function renderSuffix()
    {
        $result = '';

        if($this->suffix) {
            $result .= '<div class="input-group-addon">' . $this->suffix . '</div>';
        }

        if($this->prefix || $this->suffix) {
            $result .= '</div>';
        }

        if(!$this->isInline() && ($this->help || $this->error)) {
            $result .= '<div class="help-block">';
            $result .= $this->error ? $this->error : $this->help;
            $result .= '</div>';
        }

        return $result;
    }

    /**
     * @return bool
     */
    protected function labelShouldBeInline()
    {
        return $this->isInline() && method_exists($this->element, 'placeholder');
    }

    /**
     * @return bool
     */
    protected function isCheckbox()
    {
        return $this->element instanceof Checkbox;
    }

    /**
     * @return bool
     */
    protected function isButton()
    {
        return $this->element instanceof Button;
    }
}
