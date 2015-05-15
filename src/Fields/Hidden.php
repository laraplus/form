<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Input;

class Hidden extends Input
{
    /**
     * Initialize field settings
     */
    protected function init()
    {
        parent::init();

        $this->attributes['type'] = 'password';
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->renderField();
    }
}