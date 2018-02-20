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
use Laraplus\Form\Fields\Submit;
use Laraplus\Form\Fields\Text;
use Laraplus\Form\Fields\TextArea;

class BulmaPresenter extends BasePresenter
{
    /**
     * @return bool
     */
    protected function isInline()
    {
        return isset($this->style['form']) && strpos($this->style['form'], 'form-inline') !== false;
    }

    /**
     * @return bool
     */
    protected function isHorizontal()
    {
        return isset($this->style['form']) && strpos($this->style['form'], 'form-horizontal') !== false;
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
        $result = '<form' . $this->renderAttributes($open->attributes) . '>';
        if ($this->isInline()) {
            //$result .= '<div class="field is-horizontal is-grouped is-multiline">';
        }
        return $result;
    }

    /**
     * @param Close $close
     * @return string
     */
    public function renderClosingTag(Close $close)
    {
        $result = '</form>';
        /*
        if ($this->isInline()) {
            $result .= '</div>';
        }
        */
        return $result;
    }

    /**
     * @param Button $button
     * @return string
     */
    public function renderButton(Button $button)
    {
        if ($this->isInline()) {
            $this->element->addClass('is-block');
        }
        return '<button' . $this->renderAttributes($button->attributes) . '>' . $button->text . '</button>';
    }

    /**
     * @return string
     */
    public function renderLabel()
    {
        $result = '';

        if ($this->isHorizontal() || ($this->isInline() && !$this->isButton())) {
            $normalClass = !$this->element instanceof Checklist ? ' is-normal' : '';
            $result .= '<div class="field-label' . $normalClass . '">';
        }

        if ($this->label) {
            if ($this->isRadio()) {
                $class = "radio";
            } else {
                $class = "label";
            }
            if ($this->error) {
                $class .= ' has-text-danger';
            }

            $result .= '<label class="' . $class . '" for="' . $this->attributes['id'] . '">' . $this->label . '</label>';
        }

        if ($this->isHorizontal() || ($this->isInline() && !$this->isButton())) {
            $result .= '</div>';
        }

        return $result;
    }

    public function addElementClasses() {

        if ($this->element instanceof Input) {
            $this->element->addClass('input');
        } elseif ($this->element instanceof Button) {
            $this->element->addClass('button');
        } elseif ($this->element instanceof TextArea) {
            $this->element->addClass('textarea');
        } elseif ($this->element instanceof Radio) {
            $this->element->addClass('radio');
        } elseif ($this->element instanceof Checkbox) {
            $this->element->addClass('checkbox');
        } elseif ($this->element instanceof Checklist) {
            $this->element->addClass('checkbox');
        } elseif ($this->element instanceof Select) {
            $this->element->addClass('select');
        } elseif ($this->element instanceof TextArea) {
            $this->element->addClass('textarea');
        }
    }

    /**
     * @return string
     */
    public function renderField()
    {
        $this->addElementClasses();

        if ($this->error) {
            $this->element->addClass('is-danger');
        }

        $rendered = $this->element->render();

        if(is_array($rendered)) {
            $isInline = $this->isInline() || $this->element->inline;

            return $isInline ? $this->renderInlineList($rendered) : $this->renderList($rendered);
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
    protected function renderInlineList($elements)
    {
        $class = $this->element->multiple ? 'checkbox' : 'radio';
        $class .= $this->error ? ' has-text-danger' : '';
        $list = '';

        foreach($elements as $element) {
            $list .= '<label class="' . $class . '">' . $element . '</label>';
        }

        return $list;
    }

    /**
     * @param array $elements
     * @return string
     */
    protected function renderList($elements)
    {
        $list = '';
        $class = $this->element->multiple ? 'checkbox' : 'radio';
        $class .= $this->error ? ' has-text-danger' : '';

        foreach($elements as $element) {
            $list .= '<div><label class="' . $class . '">' . $element . '</label></div>';
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
        $this->element->addGroupClass($this->getGroupClass());

        $result = '';

        /*
        if (!$this->isInline()) {
            $result .= '<div' . $this->renderAttributes($this->element->groupAttributes) . '>';
        }
        */
        $result .= '<div' . $this->renderAttributes($this->element->groupAttributes) . '>';
        $result .= $this->renderElementGroup();
        $result .= '</div>';

        /*
        if (!$this->isInline()) {
            $result .= '</div>';
        }
        */

        return $result;
    }

    /**
     * @return string
     */
    protected function renderElementGroup()
    {
        if($this->isCheckbox()) return $this->renderCheckbox();
        //if($this->isFile()) return $this->renderFileUpload();

        $result = $this->renderLabel();

        /*
        if ($fieldContainer = $this->getElementClass()) {
            $result .= '<div' . $fieldContainer . '>';
        }
        */

        $result .= $this->renderPrefix() . $this->renderField() . $this->renderSuffix();

        /*
        if ($fieldContainer) {
            $result .= '</div>';
        }
        */

        return $result;
    }

    /**
     * @return string
     */
    protected function renderPrefix()
    {
        $result = '';
        $expandedClass = '';

        if ($this->isHorizontal() || $this->isInline()) {
            $result .= '<div class="field-body"><div class="field">';
        }

        if ($this->prefix || $this->suffix) {
            $expandedClass = ' is-expanded';
            $result .= '<div class="field has-addons">';
        }

        if($this->prefix) {
            $errorClass = $this->error ? ' is-danger is-outlined' : '';
            $result .= '<div class="control"><button class="button is-static' . $errorClass . '">' . $this->prefix . '</button></div>';
        }

        $result .= '<div class="control is-expanded">';

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

        if ($this->isHorizontal() || $this->isInline()) {
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

        $result .= $this->label ? '<label class="checkbox' . $errorClass . '" for="' . $this->attributes['id'] . '">' : '';

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

        if ($this->isHorizontal() || $this->isInline()) {
            $result .= '<div class="field-label"></div><div class="field-body"><div class="field"> ';
        }

        $this->element->addClass('file-input');

        $errorClass = $this->error ? ' has-text-danger' : '';

        $result .= '<div class="file has-name is-fullwidth' . $errorClass . '"><label class="file-label" for="' . $this->attributes['id'] . '">';

        $result .= $this->element->render();

        $result .= '<span class="file-cta"><span class="file-label"></span>' . $this->label . '</span>';

        $result .= '<span class="file-name"></span>';

        $result .= '</label></div>';

        if ($this->isHorizontal() || $this->isInline()) {
            $result .= '</div></div>';
        }

        return $result;
    }

    // TODO: has error
    /**
     * @return string
     */
    protected function getGroupClass()
    {
        $result = 'field';

        if ($this->isHorizontal() || $this->isInline()) {
            $result .= ' is-horizontal';
        }

        if ($this->isInline()) {
            $result .= ' is-inline-flex-tablet';
        }

        if ($this->error) {
            $result .= ' is-danger';
        }

        return $result;
    }
}
