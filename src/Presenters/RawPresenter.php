<?php namespace Laraplus\Form\Presenters;

use Laraplus\Contracts\FormPresenter;
use Laraplus\Form\Fields\Base\Element;

class RawPresenter implements FormPresenter {

    /**
     * @param Element $element
     * @return string
     */
    public function renderLabel(Element $element)
    {
        return '<label for="' . $element->getAttribute('id') . '">' . $element->getLabel() . '</label>';
    }

    /**
     * @param Element $element
     * @return string
     */
    public function renderError(Element $element)
    {
        return '<strong>' . $element->getError() . '</strong>';
    }

    /**
     * @param Element $element
     * @return string
     */
    public function renderElement(Element $element)
    {
        // TODO: Implement renderElement() method.
    }

    /**
     * @param string $label
     * @param string $field
     * @param string $error
     * @return string
     */
    public function renderGroup($label, $field, $error)
    {
        // TODO: Implement renderGroup() method.
    }

    /**
     * @param Element $element
     * @return string
     */
    protected function renderAttributes(Element $element)
    {
        $attributes = [];

        foreach($element->getAttributes() as $key=>$value) {
            $attributes[] = $key . '="' . $value . '"';
        }

        return implode(' ', $attributes);
    }
}