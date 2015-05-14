<?php namespace Laraplus\Form\Fields\Base;

use Laraplus\Contracts\DataStore;
use Laraplus\Contracts\FormPresenter;

abstract class Element
{
    /**
     * @var string
     */
    protected $name;

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
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->attributes['id'] = $name;
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
     * @param DataStore $dataStore
     * @param array $rules
     */
    public function setProperties(DataStore $dataStore, array $rules)
    {
        $this->rules = $rules;
        $this->dataStore = $dataStore;
    }

    /**
     * @param FormPresenter $presenter
     * @return string
     */
    public function render(FormPresenter $presenter)
    {
        $this->attributes = $presenter->prepare($this->attributes);

        $errorMessage = $this->dataStore->getError($this->getName());

        $label = $presenter->renderLabel($this->label, $this->attributes);
        $error = $presenter->renderError($errorMessage, $this->attributes);
        $field = $presenter->renderElement($this->renderField(), $this->attributes);

        return $this->presenter->renderGroup($label, $field, $error);
    }

    /**
     * @return string
     */
    public abstract function renderField();

    /**
     * @return array|string
     */
    protected function getValue()
    {
        $value = $this->dataStore->getValue($this->name);

        return $value ?: $this->value;
    }

    /**
     * Access field attributes
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
}