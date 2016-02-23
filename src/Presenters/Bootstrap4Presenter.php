<?php namespace Laraplus\Form\Presenters;

class Bootstrap4Presenter extends Bootstrap3Presenter
{
    /**
     * @return string
     */
    protected function getGroupClass()
    {
        return 'form-group' . ($this->error ? ' has-danger' : '') . ($this->isHorizontal() ? ' row' : '');
    }

    /**
     * @return string
     */
    public function renderField()
    {
        if($this->isSelect()) {
            $this->element->addClass('c-select');
        }

        return parent::renderField();
    }

    /**
     * @param array $elements
     * @param string $class
     * @return string
     */
    protected function renderList($elements, $class = '')
    {
        $list = '';
        $class = $class ? $class . ' ' : '';
        $class .= $this->element->multiple ? 'c-checkbox' : 'c-radio';

        foreach($elements as $element) {
            $element = str_replace('/>', '/>' . $this->getIndicator(), $element);

            $list .= '<label class="c-input ' . $class . '">' . $element . '</label>';
        }

        return $list;
    }

    /**
     * @param array $elements
     * @return string
     */
    protected function renderInlineList($elements)
    {
        $class = $this->element->multiple ? 'checkbox-inline' : 'radio-inline';

        return $this->renderList($elements, $class);
    }

    /**
     * @return string
     */
    protected function renderCheckbox()
    {
        $field = trim($this->prefix . $this->renderField() . $this->getIndicator() . ' ' . $this->label . $this->suffix);

        $label = '<label class="c-input c-checkbox" for="' . $this->attributes['id'] . '">' . $field .  '</label>';

        if(!$this->isHorizontal()) {
            return '<div class="checkbox">' . $label . '</div>';
        }

        return '<div'.$this->getElementClass().'>' . $label . '</div>';
    }

    /**
     * @return string
     */
    protected function getIndicator()
    {
        return '<span class="c-indicator"></span>';
    }

    /**
     * @param string $help
     * @param string $error
     * @return string
     */
    protected function formatHelpAndError($help, $error = null)
    {
        if(!$help && !$error) return '';

        $result = '<div class="text-help">';
        $result .= $error ? $error : $this->help;
        $result .= '</div>';

        return $result;
    }
}
