<?php namespace Laraplus\Form\Fields;

use Laraplus\Form\Form;
use Laraplus\Form\Contracts\DataStore;

class Open
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var method
     */
    protected $method;

    /**
     * @var method
     */
    protected $action;

    /**
     * @var DataStore
     */
    private $data;
    /**
     * @var Form
     */
    private $form;

    /**
     * @param string $name
     * @param Form $form
     * @param DataStore $data
     */
    public function __construct($name, Form $form, DataStore $data)
    {
        $this->name = $name;
        $this->data = $data;

        $this->method = 'GET';
        $this->action = $data->getUrl();
        $this->form = $form;
    }

    /**
     * @param object $model
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
        $this->method = $method;

        return $this;
    }

    /**
     * @param $action
     * @return $this
     */
    public function action($action)
    {
        $this->action = $action;

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

    public function __toString()
    {
        return '<form>';
    }
}