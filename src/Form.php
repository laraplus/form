<?php namespace Laraplus\Form;

class Form extends Elements
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param array $rules
     */
    public function setRules(array $rules)
    {
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
     * @param $name
     * @return array
     */
    public function getRules($name)
    {
        return array_get($this->rules, $name);
    }

    /**
     * @param Model $model
     */
    public function model($model)
    {
        $this->model = $model;
    }
    
}