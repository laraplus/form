<?php namespace Laraplus\Form\Fields;

use ArrayAccess;
use Laraplus\Form\Contracts\FormPresenter;
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
     * @var bool
     */
    protected $bare;
    /**
     * @var bool
     */
    protected $bareWithoutFormId;

    /**
     * @var FormPresenter
     */
    protected $presenter;

    /**
     * @param string $name
     * @param Form $form
     * @param DataStore $data
     * @param FormPresenter $presenter
     */
    public function __construct($name, Form $form, DataStore $data, FormPresenter $presenter)
    {
        $this->name = $name;
        $this->data = $data;
        $this->form = $form;

        $this->attributes['method'] = 'GET';
        $this->attributes['action'] = $data->getUrl();
        $this->presenter = $presenter;
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
     * @param style $style
     * @return $this
     */
    public function style($style = null)
    {
        $this->form->style($style);

        return $this;
    }

    /**
     * @param ArrayAccess|array $model
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
     * @param $id
     * @return $this
     */
    public function id($id)
    {
        $this->attributes['id'] = $id;

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
     * @return $this
     */
    public function multipart()
    {
        $this->attributes['enctype'] = 'multipart/form-data';

        return $this;
    }

    /**
     * @param string $class
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
     * @param bool $withFormId
     * @return $this
     */
    public function bare($withFormId = true)
    {
        $this->bare = true;

        if(!$withFormId) {
            $this->bareWithoutFormId = true;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isSubmitted()
    {
        return $this->data->getOldValue('_form') == $this->name;
    }

    /**
     * Magic getter
     * @param $property
     * @return string
     */
    public function __get($property)
    {
        if ($property == 'name') {
            return $this->name;
        }
        if ($property == 'bare') {
            return $this->bare;
        }
        if ($property == 'attributes') {
            return $this->attributes;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->bareWithoutFormId) return '';

        $append = '<input type="hidden" name="_form" value="' . $this->name . '" />';

        if ($this->bare) return $append;
        
        if(!in_array($this->attributes['method'], ['GET', 'POST'])) {
            $append .= '<input type="hidden" name="_method" value="' . $this->attributes['method'] . '" />';
            $this->attributes['method'] = 'POST';
        }

        return $this->presenter->renderOpeningTag($this) . $append;
    }
}
