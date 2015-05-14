<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Input;

class Password extends Input
{
    protected function init()
    {
        parent::init();

        $this->attributes['type'] = 'password';
    }
}