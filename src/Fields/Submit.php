<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Button;

class Submit extends Button
{
    /**
     * Initialize field settings
     */
    protected function init()
    {
        parent::init();

        $this->text = 'Submit';
        $this->attributes['type'] = 'submit';
        $this->attributes['id'] = !$this->name ? $this->attributes['id'] . 'submit' : $this->attributes['id'];
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->presenter->renderButton($this);
    }
}