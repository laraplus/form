<?php namespace Laraplus\Form\Presenters;

use Laraplus\Form\Fields\Base\Button;
use Laraplus\Form\Fields\Open;

class RawPresenter extends BasePresenter
{
    /**
     * @param Open $open
     * @return string
     */
    public function renderOpeningTag(Open $open)
    {
        return '<form' . $this->renderAttributes($open->attributes) . '>';
    }

    /**
     * @param Button $button
     * @return string
     */
    public function renderButton(Button $button)
    {
        return '<button' . $this->renderAttributes($button->attributes) . '>' . $button->text . '</button>';
    }

    /**
     * @return string
     */
    public function renderLabel()
    {
        return '<label for="' . $this->attributes['id'] . '">' . $this->label . '</label>';
    }

    /**
     * @return string
     */
    public function renderField()
    {
        return $this->element->render();
    }

    /**
     * @return string
     */
    public function renderError()
    {
        return '<strong>' . $this->error . '</strong>';
    }

    /**
     * @return string
     */
    public function renderAll()
    {
        return '<div>' . $this->renderLabel() . $this->renderField() . $this->renderError() . '</div>';
    }
}
