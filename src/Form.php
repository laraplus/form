<?php namespace Laraplus\Form;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

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
        $rules = array_get($this->rules, $name);

        if (is_null($rules)) {
            $name = trim(str_replace(['[', ']'], ['.', ''], $name), '.');
            $rules = array_get($this->rules, $name);
        }

        return $rules;
    }

    /**
     * @param Model $model
     */
    public function model(Model $model)
    {
        $this->model = $model;
    }
    
}