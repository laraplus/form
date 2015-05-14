<?php namespace Laraplus\Form\Presenters;

use Laraplus\Form\Contracts\FormPresenter;

class RawPresenter implements FormPresenter
{
    /**
     * @param array $attributes
     * @return array
     */
    public function prepare(array $attributes)
    {
        return $attributes;
    }

    /**
     * @param string $label
     * @param array $attributes
     * @return string
     */
    public function renderLabel($label, array $attributes)
    {
        $for = isset($attributes['id']) ? $attributes['id'] : null;

        return '<label' . ($for ? ' for="' . $for . '"' : '') . '>' . $label . '</label>';
    }

    /**
     * @param string $error
     * @param array $attributes
     * @return string
     */
    public function renderError($error, array $attributes)
    {
        return $error;
    }

    /**
     * @param string $field
     * @param array $attributes
     * @return string
     */
    public function renderField($field, array $attributes)
    {
        return $field;
    }

    /**
     * @param string $label
     * @param string $element
     * @param string $error
     * @return string
     */
    public function renderGroup($label, $element, $error)
    {
        return '<div>' . $label . $element . $error . '</div>';
    }
}