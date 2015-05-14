<?php namespace Laraplus\Form\Fields\Base;

use Laraplus\Form\Fields\Open;
use Laraplus\Form\Contracts\DataStore;
use Laraplus\Form\Contracts\FormPresenter;

abstract class Element
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Open
     */
    protected $open;

    /**
     * @var string|array
     */
    protected $value;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @var DataStore
     */
    protected $dataStore;

    /**
     * @var FormPresenter
     */
    private $presenter;

    /**
     * @param string $name
     * @param Open $open
     * @param FormPresenter $presenter
     * @param DataStore $dataStore
     * @param array $rules
     */
    public function __construct($name, Open $open, FormPresenter $presenter, DataStore $dataStore, array $rules = null)
    {
        $this->open = $open;
        $this->name = $name;
        $this->rules = $rules;
        $this->presenter = $presenter;
        $this->dataStore = $dataStore;

        $this->init();
    }

    /**
     * Initialization function
     */
    protected function init()
    {
        $this->attributes['id'] = $this->open->name . '-' . $this->name;
    }

    /**
     * @param $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function attribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function data($name, $value)
    {
        $this->attributes['data-' . $name] = $value;

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->attributes['class'] = $class;

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function addClass($class)
    {
        $this->attributes['class'] = trim($this->attributes['class'] . ' ' . $class);

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param FormPresenter $presenter
     * @return string
     */
    public function render(FormPresenter $presenter)
    {
        $this->attributes = $presenter->prepare($this->attributes);

        $errorMessage = $this->dataStore->getError($this->name);

        $label = $presenter->renderLabel($this->label, $this->attributes);
        $error = $presenter->renderError($errorMessage, $this->attributes);
        $field = $presenter->renderField($this->renderField(), $this->attributes);

        return $this->presenter->renderGroup($label, $field, $error);
    }

    /**
     * @return string
     */
    protected function renderAttributes()
    {
        $result = [];

        foreach($this->attributes as $key => $value) {
            $result[] = $key . '="' . $value . '"';
        }

        return implode($result);
    }

    /**
     * @return string
     */
    protected abstract function renderField();

    /**
     * @return array|string
     */
    protected function getValue()
    {
        $value = $this->dataStore->getValue($this->name);

        return $value ?: $this->value;
    }

    /**
     * Magic getter
     * @param $property
     * @return string
     */
    public function __get($property)
    {
        if($property === 'name') {
            return $this->name;
        }

        if($property === 'label') {
            return $this->label;
        }

        if($property === 'value') {
            return $this->getValue();
        }

        if(isset($this->attributes[$property])) {
            return $this->attributes[$property];
        }

        return null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render($this->presenter);
    }
}