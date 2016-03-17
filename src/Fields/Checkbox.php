<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Element;

class Checkbox extends Element
{
    protected $checked = false;

    /**
     * Initialize field settings
     */
    protected function init()
    {
        parent::init();

        $this->attributes['type'] = 'checkbox';
    }

    /**
     * @return $this
     */
    public function checked()
    {
        $this->checked = true;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->attributes['value'] = $this->forceValue ?: $this->value ?: '1';

        $oldValueMatched = $this->getValue() && $this->getValue() == $this->attributes['value'];
        $checkedByDefault = $this->checked && !$this->open->isSubmitted();

        $checked = $oldValueMatched || $checkedByDefault ? ' checked' : '';

        $attributes = $this->renderAttributes($this->attributes);

        return '<input' . $attributes . $checked . ' />';
    }

    /**
     * @return array|string
     */
    protected function getValue()
    {
        if ($value = $this->forceValue) {
            return $value;
        }

        $name = $this->getRealName();
        $old = $this->dataStore->getOldValue($name);

        if ($this->open->isSubmitted() && isset($old)) {
            return $old;
        }

        return !$this->open->isSubmitted() ? $this->dataStore->getModelValue($name) : null;
    }

    /**
     * @return string
     */
    protected function getRealName()
    {
        return $this->name;
    }
}