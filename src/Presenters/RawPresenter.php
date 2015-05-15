<?php namespace Laraplus\Form\Presenters;

class RawPresenter extends BasePresenter
{
    /**
     * @param array $items
     * @return string
     */
    public function implode(array $items)
    {
        return '<ul><li>' . implode('</li><li>', $items) . '</li></ul>';
    }

    /**
     * @param string $field
     * @return string
     */
    public function render($field)
    {
        $label = $this->renderLabel();
        $error = $this->renderError();
        $attributes = $this->renderAttributes($this->groupAttributes);

        $element = $label . $this->prefix . $field . $this->suffix . $error;

        return '<div' . $attributes . '>' . $element . '</div>';
    }

    /**
     * @return string
     */
    protected function renderLabel()
    {
        if(!$this->label) return '';

        $attribute = isset($this->attributes['id']) ? ' for="' . $this->attributes['id'] . '"' : '';

        return '<label' . $attribute . '>' . $this->label . '</label>';
    }

    /**
     * @return string
     */
    protected function renderError()
    {
        if(!$this->error) return '';

        return '<strong class="error">' . $this->error . '</strong>';
    }
}