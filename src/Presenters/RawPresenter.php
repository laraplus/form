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
        return $this->label ? '<label for="' . $this->attributes['id'] . '">' . $this->label . '</label>' : '';
    }

    /**
     * @return string
     */
    public function renderField()
    {
        $rendered = $this->element->render();

        if(is_array($rendered)) {
            return $this->renderList($rendered);
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
        $wrap = $this->element->inline ? 'span' : 'div';

        foreach($elements as $element) {
            $list .= "<$wrap>" . $element . "</$wrap>";
        }

        return $list;
    }

    /**
     * @return string
     */
    public function renderError()
    {
        return $this->error ? '<strong>' . $this->error . '</strong>' : '';
    }

    /**
     * @return string
     */
    public function renderAll()
    {
        $wrap = isset($this->style['wrap']) ? $this->style['wrap'] : 'div';

        return "<$wrap>" . $this->renderLabel() . $this->renderField() . $this->renderError() . "</$wrap>";
    }
}
