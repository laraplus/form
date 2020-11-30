<?php namespace Laraplus\Form\Fields\Base;

abstract class Input extends Element
{
    /**
     * @param string $type
     * @return $this
     */
    public function type($type)
    {
        $this->attributes['type'] = $type;

        return $this;
    }

    /**
     * @param string $placeholder
     * @return $this
     */
    public function placeholder($placeholder)
    {
        $this->attributes['placeholder'] = $placeholder;

        return $this;
    }
    
    /**
     * @return $this
     */
    public function labelToPlaceholder()
    {
        $label = $this->label;
        $this->label = null;

        if($this->hasRequiredRule()) {
            $style = $this->presenter->getStyle();

            if(isset($style['required'])) {
                $label = str_replace($style['required'], '', $label);
            }
        }

        $this->attributes['placeholder'] = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->attributes['value'] = $this->getValue();

        $attributes = $this->renderAttributes($this->attributes);

        return '<input' . $attributes . ' />';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->attributes['type'];
    }
}
