<?php namespace Laraplus\Form\Contracts;

use Laraplus\Form\Contracts\FormPresenter;

interface FormElement
{
    /**
     * @return string
     */
    public function render();

    /**
     * @param FormPresenter $presenter
     * @return string
     */
    public function present(array $style);

}