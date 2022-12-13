<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Fields\Base\Input;

class File extends Input
{
    /**
     * @var bool
     */
    protected $multiple = false;
    
    /**
     * @var string
     */
    protected $prompt = null;

    /**
     * Initialize field settings
     */
    protected function init()
    {
        parent::init();

        $this->attributes['type'] = 'file';
    }

    /**
     * @return $this
     */
    public function multiple()
    {
        $this->multiple = true;

        return $this;
    }

    /**
     * @param string $mime
     * @return $this
     */
    public function accept($mime)
    {
        $this->attributes['accept'] = $mime;

        return $this;
    }
    
    /**
     * @param string $prompt
     * @return $this
     */
    public function prompt($prompt)
    {
        $this->prompt = $prompt;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @return string
     */
    public function render()
    {
        $attributes = $this->renderAttributes($this->attributes);

        $multiple = $this->multiple ? ' multiple' : '';

        return '<input' . $attributes . $multiple . ' />';
    }
}
