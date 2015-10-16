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

        $this->attributes['type'] = 'hidden';
    }

    /**
     * @return string
     */
    public function present($style = null)
    {
        return $this->render();
    }
}