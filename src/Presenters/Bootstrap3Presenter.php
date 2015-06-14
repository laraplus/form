<?php namespace Laraplus\Form\Presenters;

use Laraplus\Form\Fields\Open;

class Bootstrap3Presenter extends BasePresenter
{
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
    protected function getElementClass()
    {
        return isset($this->style['element']) ? ' class="' . $this->style['element'] . '"' : '';
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
     * @return string
     */
    public function renderLabel()
    {
        if (!$this->label) {
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
        $this->element->addClass('form-control');

        return $this->element->render();
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
        $field = $this->renderField();
        $error = $this->renderError();
        $label = $this->renderLabel();

        $result = '<div class="form-group">';
        $result .= $label;

        if ($fieldContainer = $this->getElementClass()) {
            $result .= '<div' . $fieldContainer . '>';
        }

        $result .= $field;

        if ($fieldContainer = $this->getElementClass()) {
            $result .= '</div>';
        }

        $result .= $error . '</div>';

        return $result;
    }
}