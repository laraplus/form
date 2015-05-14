<?php namespace Laraplus\Form;

use ArrayAccess;
use Laraplus\Form\Fields\Open;
use Laraplus\Form\Fields\Close;
use Laraplus\Form\Contracts\DataStore;
use Laraplus\Form\Contracts\FormPresenter;
use Laraplus\Form\Fields\Base\Element;

class Form extends Elements
{
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
     * @param FormPresenter $presenter
     * @param DataStore $dataStore
     */
    public function __construct(FormPresenter $presenter, DataStore $dataStore)
    {
        $this->presenter = $presenter;
        $this->dataStore = $dataStore;

        $this->reset();
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
     * @param FormPresenter $presenter
     * @return string
     */
    public function render(FormPresenter $presenter = null)
    {
        if($presenter) {
            $this->presenter = $presenter;
        }

        $result = '';
        foreach($this->elements as $element) {
            $result .= $element->render($this->presenter);
        }

        return $result;
    }

    /**
     * @param string $type
     * $param string $name
     * @return Element
     */
    protected function addElement($type, $name)
    {
        $class = 'Laraplus\\Form\\Fields\\' . studly_case($type);

        $element = new $class($name, $this->open, $this->presenter, $this->dataStore, array_get($this->rules, $name));

        return $this->elements[] = $element;
    }

    /**
     * @param string $name
     * @return Open
     */
    protected function openForm($name)
    {
        $form = new Open($name, $this, $this->dataStore);

        return $this->open = $form;
    }

    /**
     * @return Close
     */
    protected function closeForm()
    {
        $form = new Close($this->open, $this->dataStore);

        return $this->close = $form;
    }

    /**
     * @param array $rules
     */
    protected function parseRules(array $rules) {

        foreach ($rules as $name => $fieldRules) {

            if (!is_array($fieldRules)) {
                $fieldRules = array_map('trim', explode('|', $fieldRules));
            }

            foreach ($fieldRules as $rule) {

                if (($colon = strpos($rule, ':')) !== false) {
                    $parameters = str_getcsv(substr($rule, $colon + 1));
                    $rule = substr($rule, 0, $colon);
                }

                if (!isset($parameters)) $parameters = [];

                $this->rules[$name][$rule] = $parameters;
            }
        }

    }

    /*
     * Reset all of the properties
     */
    protected function reset()
    {
        $this->open = null;
        $this->close = null;
        $this->model = null;

        $this->rules = [];
        $this->elements = [];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}