<?php namespace Laraplus\Form\Contracts;

use Laraplus\Form\Fields\Open;
use Laraplus\Form\Fields\Close;
use Laraplus\Form\Fields\Base\Button;
use Laraplus\Form\Fields\Base\Element;

interface FormPresenter
{
    /**
     * @param Element $element
     */
    public function setElement(Element $element);

    /**
     * @return Element
     */
    public function getElement();

    /**
     * @param array $style
     */
    public function setStyle(array $style);

    /**
     * @return array
     */
    public function getStyle();

    /**
     * @param Open $open
     * @return string
     */
    public function renderOpeningTag(Open $open);

    /**
     * @param Close $close
     * @return string
     */
    public function renderClosingTag(Close $close);

    /**
     * @param Button $button
     * @return string
     */
    public function renderButton(Button $button);

    /**
     * @return string
     */
    public function renderLabel();

    /**
     * @return string
     */
    public function renderField();

    /**
     * @return string
     */
    public function renderError();

    /**
     * @return string
     */
    public function renderAll();

}