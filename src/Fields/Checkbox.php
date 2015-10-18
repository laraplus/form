<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Element;

class Checkbox extends Element
{
    protected $checked = false;

    /**
     * @return string
     */
    public function getType()
    {
        return 'checkbox';

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

        if ($this->open->isSubmitted() && $value = $this->dataStore->getOldValue($this->name)) {
            return $value;
        }

        return !$this->open->isSubmitted() ? $this->dataStore->getModelValue($this->name) : null;
    }
}