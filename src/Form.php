<?php namespace Laraplus\Form;

use Laraplus\Contracts\DataStore;
use Laraplus\Contracts\FormPresenter;
use Laraplus\Form\Fields\Base\Element;

class Form extends Elements
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var FormPresenter
     */
    protected $presenter;

    /**
     * @param FormPresenter $presenter
     * @param DataStore $dataStore
     * @internal param Request $request
     */
    public function __construct(FormPresenter $presenter, DataStore $dataStore, array $rules = [])
    {
        $this->presenter = $presenter;
        $this->dataStore = $dataStore;
        $this->setRules($rules);
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
     * @param object $model
     * @return $this
     */
    public function model($model)
    {
        $this->dataStore->bind($model);

        return $this;
    }

    /**
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

        $element = new $class($name, $this->dataStore, array_get($this->rules, $name));

        return $this->elements[] = $element;
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
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}