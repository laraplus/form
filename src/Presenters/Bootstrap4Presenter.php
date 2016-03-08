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
            $this->element->addClass('custom-select');
        }
        if($this->isCheckbox()) {
            $this->element->addClass('custom-control-input');
        }

        return parent::renderField();
    }

    /**
     * @param array $elements
     * @param bool $stacked
     * @return string
     */
    protected function renderList($elements, $stacked = true)
    {
        $list = '';
        $class = $this->element->multiple ? 'custom-checkbox' : 'custom-radio';

        foreach($elements as $element) {
            $list .= '<label class="custom-control ' . $class . '">' . $this->formatCustomCheckable($element) . '</label>';
        }

        return '<div' . ($stacked ? ' class="custom-controls-stacked" ' : '') . '>' . $list . '</div>';
    }

    /**
     * @param array $elements
     * @return string
     */
    protected function renderInlineList($elements)
    {
        return $this->renderList($elements, false);
    }

    /**
     * @return string
     */
    protected function renderCheckbox()
    {
        $field = trim(
            $this->prefix . $this->renderField() . $this->getIndicator() .
            $this->getDescription($this->label) . $this->suffix
        );

        $class = $this->isRadio() ? 'custom-control custom-radio' : 'custom-control custom-checkbox';
        $label = '<label class="' . $class . '" for="' . $this->attributes['id'] . '">' . $field .  '</label>';

        return '<div'.$this->getElementClass().'>' . $label . '</div>';
    }

    /**
     * @return string
     */
    protected function formatCustomCheckable($element)
    {
        // inject custom-control class
        if(str_contains($element, 'class="')) {
            $element = str_replace('class="', 'class="custom-control-input ', $element);
        } else {
            $element = str_replace('/>', 'class="custom-control-input" />', $element);
        }

        // inject description & indicator
        $description = ['<span class="custom-control-description">', '</span>'];
        $element = str_replace('/>', '/>' . $this->getIndicator() . $description[0], $element) . $description[1];

        return $element;
    }

    /**
     * @return string
     */
    protected function getIndicator()
    {
        return '<span class="custom-control-indicator"></span>';
    }

    protected function getDescription($description)
    {
        return '<span class="custom-control-description">' . $description . '</span>';
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
