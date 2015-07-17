<?php namespace Laraplus\Form\Helpers;

use Laraplus\Form\Form;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;

trait FormBuilder
{
    /**
     * @var Form
     */
    protected $formBuilder = null;

    /**
     * @return Form
     */
    public function getFormBuilder()
    {
        if ($this->formBuilder) {
            return $this->formBuilder;
        }

        $rules = method_exists($this, 'rules') ? $this->rules() : [];

        return $this->formBuilder = app('Laraplus\Form\Form')->rules($rules);
    }

    /**
     * Injects validator with rules and data if validation is required
     *
     * @param Factory $factory
     *
     * @return Validator
     */
    public function validator(Factory $factory)
    {
        if (!$this->shouldBeValidated()) {
            return $factory->make([], []);
        }

        return $factory->make(
            $this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );
    }

    /**
     * Determines if the current request should be validated
     *
     * @return bool
     */
    protected function shouldBeValidated()
    {
        return $this->method() != 'GET';
    }
}
