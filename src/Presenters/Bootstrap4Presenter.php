<?php namespace Laraplus\Form\Presenters;

class Bootstrap4Presenter extends Bootstrap3Presenter
{
    /**
     * @return string
     */
    protected function getGroupClass()
    {
        return 'form-group' . ($this->error ? ' has-error' : '') . ($this->isHorizontal() ? ' row' : '');
    }
}
