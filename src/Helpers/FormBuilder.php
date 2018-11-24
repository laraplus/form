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

        return $this->formBuilder = $this->newFormBuilder();
    }

    /**
     * @return Form
     */
    public function newFormBuilder()
    {
        $rules = method_exists($this, 'rules') ? app()->call([$this, 'rules']) : [];

        return app('Laraplus\Form\Form')->rules($rules);
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
        
        $rules = app()->call([$this, 'rules']);

        return $factory->make(
            $this->all(), $rules, $this->messages(), $this->attributes()
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
