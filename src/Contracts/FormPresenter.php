<?php namespace Laraplus\Form\Contracts;

use Laraplus\Form\Fields\Base\Element;

interface FormPresenter
{
    /**
     * @param Element $element
     * @return Element
     */
    public function decorate(Element $element);

	/**
	 * @param array $style
	 * @return mixed
	 */
	public function style(array $style);

    /**
     * @param array $items
     * @return string
     */
    public function implode(array $items);

    /**
     * @param string $field
     * @return string
     */
    public function render($field);

}