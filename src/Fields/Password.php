<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Input;

class Password extends Input
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
     * @return array|string
     */
    public function getValue()
    {
        if ($value = $this->forceValue) {
            return $value;
        }

        return null;
    }
}
