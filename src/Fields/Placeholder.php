<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Element;

class Placeholder extends Element
{
    /**
     * @var string
     */
    protected $content = '';

    /**
     * @param $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $attributes = $this->renderAttributes(array_except($this->attributes, ['name']));

        return '<div' . $attributes . '>' . $this->content . '</div>';
    }
}