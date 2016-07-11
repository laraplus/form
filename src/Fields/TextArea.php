<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Element;

class TextArea extends Element
{
    /**
     * @param string $cols
     * @return $this
     */
    public function cols($cols)
    {
        $this->attributes['cols'] = $cols;

        return $this;
    }

    /**
     * @param string $rows
     * @return $this
     */
    public function rows($rows)
    {
        $this->attributes['rows'] = $rows;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $attributes = $this->renderAttributes($this->attributes);

        return '<textarea' . $attributes . '>' . htmlspecialchars($this->getValue()) . '</textarea>';
    }
}
