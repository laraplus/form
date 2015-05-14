<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Input;

class Text extends Input
{
    protected function init()
    {
        parent::init();

        $this->attributes['type'] = 'text';
    }
}