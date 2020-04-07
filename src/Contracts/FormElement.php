<?php namespace Laraplus\Form\Contracts;

use Laraplus\Form\Contracts\FormPresenter;

interface FormElement
{
    /**
     * @return string|array
     */
    public function render();

    /**
     * @param string $style
     * @return string
     */
    public function present($style = null);

}