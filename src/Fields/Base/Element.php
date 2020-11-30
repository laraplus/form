<?php namespace Laraplus\Form\Fields\Base;

use InvalidArgumentException;
use Laraplus\Form\Fields\Open;
use Laraplus\Form\Contracts\DataStore;
use Laraplus\Form\Contracts\FormElement;
use Laraplus\Form\Contracts\FormPresenter;
use Laraplus\Form\Contracts\ConfigProvider;
use Laraplus\Form\Helpers\RendersAttributes;

/**
 * Class Element
 * @package Laraplus\Form\Fields\Base
 * @property-read string $name
 * @property-read string $label
 * @property-read string $help
 * @property-read string $error
 * @property-read string $prefix
 * @property-read string $suffix
 * @property-read array $attributes
 * @property-read array $groupAttributes
 * @property-read bool $multiple
 * @property-read bool $forcedClass
 */
abstract class Element implements FormElement
{
    use RendersAttributes;

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
     * @var string|array
     */
    protected $forceValue;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $help;

    /**
     * @var string
     */
    protected $error;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $groupAttributes;

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
    protected $presenter;

    /**
     * @var ConfigProvider
     */
    protected $config;

    /**
     * @var bool
     */
    protected $multiple = false;

    /**
     * @var null|array
     */
    protected $style = null;

    /**
     * @var bool
     */
    protected $forcedClass = false;

    /**
     * @var array
     */
    protected static $macros = [];

    /**
     * @param string $name
     * @param Open $open
     * @param FormPresenter $presenter
     * @param DataStore $dataStore
     * @param ConfigProvider $config
     * @param array $rules
     */
    public function __construct($name, Open $open, FormPresenter $presenter, DataStore $dataStore, ConfigProvider $config, array $rules = null)
    {
        $this->open = $open;
        $this->name = $name;
        $this->rules = $rules;
        $this->config = $config;
        $this->presenter = $presenter;
        $this->dataStore = $dataStore;

        $this->init();
    }

    /**
     * Add new macro
     *
     * @param $name
     * @param string $class
     */
    public static function extend($name, $class)
    {
        static::$macros[$name] = $class;
    }

    /**
     * Initialization function
     */
    protected function init()
    {
        $this->attributes = [];
        $this->groupAttributes = [];

        $this->attributes['id'] = $this->open->name . '-' . $this->name;

        if($this->name) {
            $this->attributes['name'] = $this->name;
        }
    }

    /**
     * @param $id
     * @return $this
     */
    public function id($id)
    {
        $this->attributes['id'] = $id;

        return $this;
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
     * @param $value
     * @return $this
     */
    public function forceValue($value)
    {
        $this->forceValue = $value;

        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function label($label = null)
    {
        // When label is called without parameters, we will
        // assume that a user wants to get the rendered
        // html, so we'll defer it to  __call method
        if(is_null($label)) return $this->__call('label', []);

        $this->label = $label;

        if($this->hasRequiredRule()) {
            $style = $this->presenter->getStyle();

            $this->label .= isset($style['required']) ? $style['required'] : '';
        }

        return $this;
    }
    
    /**
     * @return bool
     */
    protected function hasRequiredRule()
    {
        foreach($this->rules ?: [] as $rule => $value) {
            if(substr($rule, 0, strlen('required')) == 'required') {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $help
     * @return $this
     */
    public function help($help)
    {
        $this->help = $help;

        return $this;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function prefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @param string $suffix
     * @return $this
     */
    public function suffix($suffix)
    {
        $this->suffix = $suffix;

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
     * Alias for attribute()
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function attr($name, $value)
    {
        return $this->attribute($name, $value);
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function groupAttribute($name, $value)
    {
        $this->groupAttributes[$name] = $value;

        return $this;
    }

    /**
     * Alias for groupAttribute()
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function groupAttr($name, $value)
    {
        return $this->groupAttribute($name, $value);
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
     * @param $name
     * @param $value
     * @return $this
     */
    public function groupData($name, $value)
    {
        $this->groupAttributes['data-' . $name] = $value;

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->forcedClass = true;

        $this->attributes['class'] = $class;

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function setGroupClass($class)
    {
        $this->groupAttributes['class'] = $class;

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function addClass($class)
    {
        $classes = isset($this->attributes['class']) ? $this->attributes['class'] : '';

        if (!in_array($class, explode(' ', $classes))) {
            $this->attributes['class'] = trim($classes . ' ' . $class);
        }

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function addGroupClass($class)
    {
        $classes = isset($this->groupAttributes['class']) ? $this->groupAttributes['class'] : '';

        if (!in_array($class, explode(' ', $classes))) {
            $this->groupAttributes['class'] = trim($classes . ' ' . $class);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutAjaxValidation()
    {
        unset($this->groupAttributes['data-ajax-validate-group']);

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
     * @param string $style
     * @return $this
     */
    public function style($style = null)
    {
        $this->style = $style ? $this->config->get('styles.' . $style) : null;

        return $this;
    }

    /**
     * @param string $style
     * @return string
     */
    public function present($style = null)
    {
        $resetStyle = null;
        $this->initPresenter();

        if($style = $style ? $this->config->get('styles.' . $style) : ($this->style ?: null)) {
            $resetStyle = [$this->presenter->getStyle(), $this->presenter->getStyleName()];
            $this->presenter->setStyleName($style);
            $this->presenter->setStyle($style);
        }

        $element = $this->presenter->renderAll();

        if($resetStyle) {
            $this->presenter->setStyleName($resetStyle[1]);
            $this->presenter->setStyle($resetStyle[0]);
        }

        return $element;
    }
    
    /**
     * Inject the element into presenter
     */
    protected function initPresenter()
    {
        if($this->name && $this->open->isSubmitted()) {
            $this->error = $this->dataStore->getError($this->name);
        }
        $this->presenter->setElement($this);
    }

    /**
     * @return array|string
     */
    public function getValue()
    {
        if (isset($this->forceValue)) {
            return $this->forceValue;
        }

        if ($this->open->isSubmitted()) {
            return $this->dataStore->getOldValue($this->name);
        }

        return isset($this->value) ? $this->value : $this->dataStore->getModelValue($this->name);
    }

    /**
     * Magic getter
     * @param $property
     * @return string
     */
    public function __get($property)
    {
        $properties = [
            'open',
            'name',
            'label',
            'help',
            'error',
            'prefix',
            'suffix',
            'rules',
            'attributes',
            'groupAttributes',
            'multiple',
            'forcedClass'
        ];

        if (in_array($property, $properties)) {
            return $this->$property;
        }

        throw new InvalidArgumentException('Cannot access [' . $property . '] property on an Element');
    }

    /**
     * @param string $method
     * @param array $args
     * @return string
     */
    public function __call($method, $args)
    {
        if(isset(static::$macros[$method])) {
            $result = call_user_func_array(static::$macros[$method], array_merge([$this], $args));

            return $result?: $this;
        }

        $methods = [
            'label',
            'error',
            'field',
        ];

        if (in_array($method, $methods)) {
            
            $method = 'render' . ucfirst($method);
            $this->initPresenter();
            
            return $this->presenter->$method();
        }

        if($method == 'fieldWithError') {
            return $this->field().$this->error();
        }

        throw new InvalidArgumentException('Cannot call [' . $method . '] method on an Element');
    }

    /**
     * @param $property
     * @param $value
     * @return mixed
     */
    public function __set($property, $value)
    {
        $properties = ['open'];

        if (in_array($property, $properties)) {
            $this->$property = $value;
            return;
        }

        throw new InvalidArgumentException('Cannot set [' . $property . '] on an Element');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->present();
    }
}
