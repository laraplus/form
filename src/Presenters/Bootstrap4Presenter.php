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
        if($this->error && !$this->isButton() && !$this->isCheckbox()) {
            $this->element->addClass('form-control-danger');
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
            $list .= '<label class="' . $this->getCustomControlClass($element) . '">' .
                         $this->formatCustomCheckable($element) .
                     '</label>';
        }

        return '<div' . ($stacked ? ' class="custom-controls-stacked" ' : '') . '>' . $list . '</div>';
    }

    protected function getCustomControlClass($element)
    {
        $class = $this->element->multiple ? 'custom-checkbox' : 'custom-radio';

        return trim('custom-control ' . $class);
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
        $element = $this->renderField();

        $field = trim(
            $this->prefix . $element . $this->getIndicator($element) .
            $this->getDescription($this->label) . $this->suffix
        );

        $class = $this->isRadio() ? 'custom-control custom-radio' : 'custom-control custom-checkbox';
        $label = '<label class="' . $class . '" for="' . $this->attributes['id'] . '">' . $field .  '</label>';

        return '<div'.$this->getElementClass().'>' . $label . $this->renderError() . '</div>';
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
        $element = str_replace('/>', '/>' . $this->getIndicator($element) . $description[0], $element) . $description[1];

        return $element;
    }

    /**
     * @return string
     */
    protected function getIndicator($element)
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
        $result = '';

        if($error) {
            $result .= '<div class="form-control-feedback">' . $error . '</div>';
        }
        if($help) {
            $result .= '<div class="form-text text-muted">' . $help . '</div>';
        }

        return $result;
    }
}
