<?php namespace Laraplus\Form;

use Closure;
use Countable;
use Exception;
use ArrayAccess;
use BadMethodCallException;
use Laraplus\Form\Fields\Open;
use Laraplus\Form\Fields\Close;
use Laraplus\Form\Fields\Base\Element;
use Laraplus\Form\Contracts\DataStore;
use Laraplus\Form\Contracts\FormPresenter;
use Laraplus\Form\Contracts\ConfigProvider;

class Form extends Elements implements ArrayAccess, Countable
{
    /**
     * @var int
     */
    protected static $copies = 0;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @var ArrayAccess
     */
    protected $model;

    /**
     * @var FormPresenter
     */
    protected $presenter;

    /**
     * @var DataStore
     */
    protected $dataStore;

    /**
     * @var ConfigProvider
     */
    protected $config;

    /**
     * @var string
     */
    protected $style;

    /**
     * @var Open
     */
    protected $open;

    /**
     * @var Close
     */
    protected $close;

    /**
     * @var array
     */
    protected $elements;

    /**
     * @var array
     */
    protected $ajaxValidation = false;

    /**
     * @var array
     */
    protected $dynamicProperties = [];

    /**
     * @var array
     */
    protected static $macros = [];

    /**
     * @var array
     */
    protected static $properties = [];

    /**
     * @param FormPresenter $presenter
     * @param DataStore $dataStore
     * @param ConfigProvider $config
     */
    public function __construct(FormPresenter $presenter, DataStore $dataStore, ConfigProvider $config)
    {
        $this->presenter = $presenter;
        $this->dataStore = $dataStore;
        $this->config = $config;

        $this->style($this->config->get('style'));

        $this->reset();
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
     * Register new dynamic property
     *
     * @param $name
     */
    public static function registerDynamicProperty($name)
    {
        static::$properties[$name] = true;
    }

    /**
     * Read dynamic property
     *
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public function getDynamicProperty($name, $default = null)
    {
        return isset($this->dynamicProperties[$name]) ? $this->dynamicProperties[$name] : $default;
    }

    /**
     * @param FormPresenter $presenter
     * @return $this
     */
    public function presenter(FormPresenter $presenter)
    {
        $this->presenter = $presenter;

        return $this;
    }

    /**
     * @param array $rules
     * @return $this
     */
    public function rules(array $rules)
    {
        $this->parseRules($rules);

        return $this;
    }

    /**
     * @param ArrayAccess $model
     * @return $this
     */
    public function model($model)
    {
        $this->dataStore->bind($model);

        return $this;
    }

    /**
     * @param string $style
     * @return $this
     */
    public function style($style = null)
    {
        if ($style) {
            $this->style = $style;
            $this->presenter->setStyle($this->config->get('styles.' . $this->style));
            $this->presenter->setStyleName($this->style);
        }

        return $this;
    }


    /**
     * @param $name
     * @param Closure $builder
     * @return $this
     */
    public function group($name, Closure $builder)
    {
        $instance = new self($this->presenter, $this->dataStore, $this->config);
        $instance->rules = $this->rules;

        $instance->open($this->open->name)
            ->bare($withFormId = false)
            ->style($this->style)
            ->forceSubmittedStatus($this->open->isSubmitted());

        $builder($instance);

        $instance->close();

        $this->elements[$name ?: 'element-' . count($this->elements)] = $instance;

        return $this;
    }

    /**
     * @param string $style
     * @return string
     */
    public function render($style = null)
    {
        $this->style($style);

        return $this->open . "\n" . $this->renderElements() . "\n" . $this->close;
    }

    /**
     * Alias for render()
     *
     * @param string $style
     * @return string
     */
    public function present($style = null)
    {
        return $this->render($style);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isSubmitted()
    {
        if(!$this->open) {
            throw new Exception('Cannot call Form::isSubmitted() without calling Form::open() first.');
        }

        return $this->open->isSubmitted();
    }

    /**
     * @return $this
     */
    public function withAjaxValidation()
    {
        $this->ajaxValidation = true;

        if($this->open) {
            $this->open->attribute('data-ajax-validate', $this->open->name);
        }

        foreach($this->elements as $name => $element) {
            if($element instanceof Element) {
                $element->groupAttr('data-ajax-validate-group', $name);
            } elseif ($element instanceof static) {
                $element->withAjaxValidation();
            }
        }

        return $this;
    }
    
    /**
     * @return string
     */
    protected function renderElements()
    {
        $result = [];
        
        foreach ($this->elements as $element) {
            $result[] = $element->present();
        }
        
        return implode("\n", $result);
    }

    /**
     * @param $type
     * @param $name
     * @param bool $isMacro
     * @return Element
     * @throws Exception
     */
    protected function addElement($type, $name, $isMacro = false)
    {
        $this->enforceOpenForm($type);

        $class = $isMacro ? static::$macros[$type] : 'Laraplus\\Form\\Fields\\' . studly_case($type);
        
        $ruleName = str_replace(['[', ']'], ['.', ''], $name);

        $element = new $class($name, $this->open, $this->presenter, $this->dataStore, $this->config, array_get($this->rules, $ruleName));

        if($this->ajaxValidation) {
            $element->groupAttr('data-ajax-validate-group', $name);
        }

        return $this->elements[$name ?: 'element-' . count($this->elements)] = $element;
    }

    /**
     * @param string $name
     * @return Open
     */
    protected function openForm($name)
    {
        $form = new Open($name, $this, $this->dataStore, $this->presenter);

        if($this->ajaxValidation) {
            $form->attribute('data-ajax-validate', $name);
        }

        return $this->open = $form;
    }

    /**
     * @return Close
     * @throws Exception
     */
    protected function closeForm()
    {
        $this->enforceOpenForm('close');

        $form = new Close($this->open, $this->dataStore, $this->presenter);

        return $this->close = $form;
    }

    /**
     * @param string $type
     * @throws Exception
     */
    protected function enforceOpenForm($type)
    {
        if (!$this->open) {
            throw new Exception('Cannot call Form::' . camel_case($type) . '() without calling Form::open() first.');
        }
    }

    /**
     * @param array $rules
     */
    protected function parseRules(array $rules)
    {
        foreach ($rules as $name => $fieldRules) {

            if (!is_array($fieldRules)) {
                $fieldRules = array_map('trim', explode('|', $fieldRules));
            }

            foreach ($fieldRules as $rule) {
                
                if(!is_string($rule)) {
                    continue;
                }

                if (($colon = strpos($rule, ':')) !== false) {
                    $parameters = str_getcsv(substr($rule, $colon + 1));
                    $rule = substr($rule, 0, $colon);
                }

                if (!isset($parameters)) {
                    $parameters = [];
                }

                $this->rules[$name][$rule] = $parameters;
            }
        }
    }

    /**
     * Reset all of the properties
     */
    protected function reset()
    {
        $this->open = null;
        $this->close = null;
        $this->model = null;
        $this->style = $this->config->get('style');

        $this->elements = [];
    }
    
    /**
     * Return all elements
     *
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Get single element
     *
     * @param $property
     * @throws Exception
     * @return Element
     */
    public function __get($property)
    {
        if ($property == 'open') {
            return $this->open;
        }
        if ($property == 'close') {
            return $this->close;
        }
        if($property == 'elements') {
            return $this->renderElements();
        }

        if (isset($this->elements[$property])) {
            return $this->elements[$property];
        }

        throw new Exception('Element [' . $property . '] does not exist');
    }

    /**
     * Handle macro calls
     *
     * @param $method
     * @param $args
     * @return $this
     */
    public function __call($method, $args)
    {
        if(isset(static::$macros[$method])) {
            return $this->addElement($method, array_shift($args), true);
        }

        if(isset(static::$properties[$method])) {
            $this->dynamicProperties[$method] = count($args) == 0 ?: (count($args) == 1 ? $args[0] : $args);

            foreach($this->elements as $name => $element) {
                if ($element instanceof static) {
                    $element->$method(...$args);
                }
            }

            return $this;
        }

        throw new BadMethodCallException('Method [' . $method . '] does not exist on Form class');
    }

    /**
     * Clone all elements
     */
    public function __clone()
    {
        static::$copies++;
        $this->open = clone $this->open;
        $this->close = clone $this->close;

        foreach($this->elements as $key => $element) {

            $this->elements[$key] = clone $element;

            if($this->elements[$key] instanceof Element) {
                $this->elements[$key]->id($this->elements[$key]->attributes['id'] . '-copy-' . static::$copies);
                $this->elements[$key]->open = $this->open;
            }
        }

        $this->open->name($this->open->name . '-copy-' . static::$copies);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return in_array($offset, ['open', 'close']) || isset($this->elements[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->elements[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->elements[$offset]);
    }
    
    /**
     * @return int
     */
    public function count()
    {
        return count($this->elements);
    }
}
