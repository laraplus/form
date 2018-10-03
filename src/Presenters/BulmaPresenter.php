<?php namespace Laraplus\Form\Presenters;

use Laraplus\Form\Fields\Base\Button;
use Laraplus\Form\Fields\Base\Input;
use Laraplus\Form\Fields\Checkbox;
use Laraplus\Form\Fields\Checklist;
use Laraplus\Form\Fields\Close;
use Laraplus\Form\Fields\File;
use Laraplus\Form\Fields\Open;
use Laraplus\Form\Fields\Radio;
use Laraplus\Form\Fields\Select;
use Laraplus\Form\Fields\TextArea;

class BulmaPresenter extends BasePresenter
{
    /**
     * @return bool
     */
    protected function isInline()
    {
        return isset($this->styleName) && strpos($this->styleName, 'inline') !== false;
    }

    /**
     * @return bool
     */
    protected function isHorizontal()
    {
        return isset($this->styleName) && strpos($this->styleName, 'horizontal') !== false;
    }

    /**
     * @return bool
     */
    protected function isVertical()
    {
        return !$this->isInline() && !$this->isHorizontal();
    }

    /**
     * @return bool
     */
    protected function isCheckbox()
    {
        return $this->element instanceof Checkbox;
    }

    /**
     * @return bool
     */
    protected function isFile()
    {
        return $this->element instanceof File;
    }

    /**
     * @return bool
     */
    protected function isRadio()
    {
        return $this->element instanceof Radio;
    }

    /**
     * @return bool
     */
    protected function isChecklist()
    {
        return $this->element instanceof Checklist;
    }

    /**
     * @return bool
     */
    protected function isButton()
    {
        return $this->element instanceof Button;
    }

    /**
     * @return bool
     */
    protected function isSelect()
    {
        return $this->element instanceof Select && !$this->element->multiple;
    }

    /**
     * @return bool
     */
    protected function isList()
    {
        return $this->element instanceof Checklist;
    }

    /**
     * @param Open $open
     * @return string
     */
    public function renderOpeningTag(Open $open)
    {
        if (isset($this->style['form']) && !$this->forcedClass) {
            $open->addClass($this->style['form']);
        }

        $result = '<form' . $this->renderAttributes($open->attributes) . '>';
        return $result;
    }

    /**
     * @param Close $close
     * @return string
     */
    public function renderClosingTag(Close $close)
    {
        $result = '</form>';
        return $result;
    }

    /**
     * @param Button $button
     * @return string
     */
    public function renderButton(Button $button)
    {
        return '<button' . $this->renderAttributes($button->attributes) . '>' . $button->text . '</button>';
    }

    /**
     * @return string
     */
    public function renderLabel()
    {
        $result = '';

        if ($this->isHorizontal()) {
            $normalClass = !$this->element instanceof Checklist ? ' is-normal' : '';
            $result .= '<div class="field-label' . $normalClass . '">';
        }

        if ($this->label) {
            $classes = $this->getLabelClasses();

            $result .= '<label class="' . $classes . '" for="' . $this->attributes['id'] . '">' . $this->label . '</label>';
        }

        if ($this->isHorizontal()) {
            $result .= '</div>';
        }

        return $result;
    }

    /**
     * @return string
     */
    public function renderField()
    {
        $this->element->addClass($this->getElementClasses());

        if ($this->error) {
            $this->element->addClass('is-danger');
        }

        $rendered = $this->element->render();

        if(is_array($rendered)) {
            $isInline = $this->isInline() || $this->element->inline;

            return $this->renderList($rendered, $isInline);
        }

        if ($this->isSelect()) {
            $errorClass = $this->error ? ' is-danger' : '';
            $rendered = '<div class="select is-fullwidth' . $errorClass . '">' . $rendered . '</div>';
        }

        return $rendered;
    }

    /**
     * @param array $elements
     * @return string
     */
    protected function renderList($elements, $inline = false)
    {
        $list = '';
        $class = $this->element->multiple ? $this->style['label-checkbox'] : $this->style['label-radio'];
        $class .= $this->error ? ' has-text-danger' : '';

        foreach($elements as $key => $element) {
            if ($this->element instanceof Checklist) {
                $item = '<label class="' . $class . '"' . $this->element->renderLabelAttributes($key) . '>' . $element . '</label>';
            } else {
                $item = '<label class="' . $class . '">' . $element . '</label>';
            }

            if (!$inline) {
                $list .= '<div>' . $item . '</div>';
            } else {
                $list .= $item;
            }
        }

        return $list;
    }

    /**
     * @return string
     */
    public function renderError()
    {
        return $this->error ? '<strong>' . $this->error . '</strong>' : '';
    }

    /**
     * @return string
     */
    public function renderAll()
    {
        $this->element->addGroupClass($this->getGroupClasses());

        $result = '';

        $result .= '<div' . $this->renderAttributes($this->element->groupAttributes) . '>';
        $result .= $this->renderElementGroup();
        $result .= '</div>';

        return $result;
    }

    /**
     * @return string
     */
    protected function renderElementGroup()
    {
        if($this->isCheckbox()) return $this->renderCheckbox();

        $result = $this->renderLabel();

        $result .= $this->renderPrefix() . $this->renderField() . $this->renderSuffix();

        return $result;
    }

    /**
     * @return string
     */
    protected function renderPrefix()
    {
        $result = '';
        $controlClass = "control";

        if ($this->isHorizontal()) {
            $result .= '<div class="field-body"><div class="field">';
        }

        if ($this->prefix || $this->suffix) {
            $result .= '<div class="field has-addons">';
        }

        if($this->prefix) {
            $errorClass = $this->error ? ' is-danger is-outlined' : '';
            $result .= '<div class="control"><button class="button is-static' . $errorClass . '">' . $this->prefix . '</button></div>';
        }

        if ($this->style['element']) {
            $controlClass .= ' ' . $this->style['element'];
        }

        $result .= '<div class="' . $controlClass . '">';

        return $result;
    }

    /**
     * @return string
     */
    protected function renderSuffix()
    {
        $result = '</div>';

        if($this->suffix) {
            $errorClass = $this->error ? ' is-danger is-outlined' : '';
            $result .= '<div class="control"><button class="button is-static' . $errorClass . '">' . $this->suffix . '</button></div>';
        }

        if ($this->prefix || $this->suffix) {
            $result .= '</div>';
        }

        $result .= $this->formatHelpAndError($this->help, $this->error);

        if ($this->isHorizontal()) {
            $result .= '</div></div>';
        }

        return $result;
    }

    /**
     * @param string $help
     * @param string $error
     * @return string
     */
    protected function formatHelpAndError($help, $error = null)
    {
        if(!$help && !$error) return '';

        $helpClass = $error ? ' is-danger' : '';

        $result = '<p class="help' . $helpClass . '">';
        $result .= $error ? $error : $this->help;
        $result .= '</p>';

        return $result;
    }

    /**
     * @return string
     */
    protected function renderCheckbox()
    {
        $result = '';

        if ($this->isHorizontal()) {
            $result .= '<div class="field-label"></div>';
        }

        $errorClass = $this->error ? ' has-text-danger' : '';

        $result .= $this->renderPrefix();

        $result .= $this->label ? '<label class="' . $this->style['label-checkbox'] . $errorClass . '" for="' . $this->attributes['id'] . '">' : '';

        $result .= $this->renderField();

        $result .= $this->label ? $this->label . '</label>' : '';

        $result .= $this->renderSuffix();

        return $result;
    }

    /**
     * @return string
     */
    protected function renderFileUpload()
    {
        $result = '';

        if ($this->isHorizontal()) {
            $result .= '<div class="field-label"></div><div class="field-body"><div class="field"> ';
        }

        $this->element->addClass('file-input');

        $errorClass = $this->error ? ' has-text-danger' : '';

        $result .= '<div class="file has-name is-fullwidth' . $errorClass . '"><label class="file-label" for="' . $this->attributes['id'] . '">';

        $result .= $this->element->render();

        $result .= '<span class="file-cta"><span class="file-label"></span>' . $this->label . '</span>';

        $result .= '<span class="file-name"></span>';

        $result .= '</label></div>';

        if ($this->isHorizontal()) {
            $result .= '</div></div>';
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function getElementClasses() {

        if ($this->element instanceof Input) {
            $class = 'input';
        } elseif ($this->element instanceof Checklist) {
            if ($this->element->multiple) {
                $class = 'checkbox';
            } else {
                $class = 'radio';
            }
        } elseif ($this->element instanceof Button) {
                $class = 'button';
        } else {
            $class = strtolower(class_basename($this->element));
        }

        return $class;
    }

    /**
     * @return string
     */
    protected function getGroupClasses()
    {
        $class = 'field';

        $class .= ' ' . $this->style['field'];

        if ($this->error) {
            $class .= ' is-danger';
        }

        return $class;
    }

    /**
     * @return string
     */
    protected function getLabelClasses()
    {
        $class = $this->style['label'];

        if ($this->error) {
            $class .= ' has-text-danger';
            return $class;
        }

        return $class;
    }
}
