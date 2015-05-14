<?php namespace Laraplus\Form\Contracts;

use Laraplus\Form\Fields\Base\Element;

interface FormPresenter
{
    /**
     * @param array $attributes
     * @return array
     */
    public function prepare(array $attributes);

    /**
     * @param string $label
     * @param array $attributes
     * @return string
     */
    public function renderLabel($label, array $attributes);

    /**
     * @param string $error
     * @param array $attributes
     * @return string
     */
    public function renderError($error, array $attributes);

    /**
     * @param string $field
     * @param array $attributes
     * @return string
     */
    public function renderField($field, array $attributes);

    /**
     * @param string $label
     * @param string $element
     * @param string $error
     * @return string
     */
    public function renderGroup($label, $element, $error);

}