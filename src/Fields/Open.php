<?php namespace Laraplus\Form\Fields;

use ArrayAccess;
use Laraplus\Form\Form;
use Laraplus\Form\Contracts\DataStore;

class Open
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var DataStore
     */
    protected $data;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @param string $name
     * @param Form $form
     * @param DataStore $data
     */
    public function __construct($name, Form $form, DataStore $data)
    {
        $this->name = $name;
        $this->data = $data;
        $this->form = $form;

        $this->attributes['method'] = 'GET';
        $this->attributes['action'] = $data->getUrl();
    }

    /**
     * @param ArrayAccess $model
     * @return $this
     */
    public function model($model)
    {
        $this->form->model($model);

        return $this;
    }

    /**
     * @param array $rules
     * @return $this
     */
    public function rules(array $rules)
    {
        $this->form->rules($rules);

        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    public function method($method)
    {
        $this->attributes['method'] = $method;

        return $this;
    }

    /**
     * @param $action
     * @return $this
     */
    public function action($action)
    {
        $this->attributes['action'] = $action;

        return $this;
    }

    /**
     * @return $this
     */
    public function multipart()
    {
        $this->attributes['enctype'] = 'multipart/form-data';

        return $this;
    }

    /**
     * Magic getter
     * @param $property
     * @return string
     */
    public function __get($property)
    {
        if($property == 'name') {
            return $this->name;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $attributes = [];

        foreach($this->attributes as $key => $value) {
            $attributes[] = $key . '="' . $value . '"';
        }

        return '<form ' . implode(' ', $attributes) . '>';
    }
}