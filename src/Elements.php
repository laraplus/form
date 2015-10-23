<?php namespace Laraplus\Form;

use Laraplus\Form\Fields\File;
use Laraplus\Form\Fields\Open;
use Laraplus\Form\Fields\Text;
use Laraplus\Form\Fields\Close;
use Laraplus\Form\Fields\Group;
use Laraplus\Form\Fields\Select;
use Laraplus\Form\Fields\Submit;
use Laraplus\Form\Fields\Password;
use Laraplus\Form\Fields\Checkbox;
use Laraplus\Form\Fields\Checklist;
use Laraplus\Form\Fields\Base\Element;

abstract class Elements
{
    /**
     * @var array
     */
    protected static $macros = [];

    /**
     * Add a new macro
     *
     * @param $name
     * @param string $class
     */
    public function extend($name, $class)
    {
        static::$macros[$name] = $class;
    }

    /**
     * @param $name
     * @return Open
     */
    public function open($name)
    {
        $this->reset();

        return $this->openForm($name);
    }

    /**
     * @return Close
     */
    public function close()
    {
        return $this->closeForm();
    }

    /**
     * @param string $name
     * @return Text
     */
    public function text($name)
    {
        return $this->addElement('text', $name);
    }

    /**
     * @param string $name
     * @return Password
     */
    public function password($name)
    {
        return $this->addElement('password', $name);
    }

    /**
     * @param string $name
     * @return Password
     */
    public function hidden($name)
    {
        return $this->addElement('hidden', $name);
    }

    /**
     * @param string $name
     * @return Select
     */
    public function select($name)
    {
        return $this->addElement('select', $name);
    }

    /**
     * @param string $name
     * @return Checkbox
     */
    public function checkbox($name)
    {
        return $this->addElement('checkbox', $name);
    }

    /**
     * @param string $name
     * @return Checklist
     */
    public function checklist($name)
    {
        return $this->addElement('checklist', $name);
    }

    /**
     * @param $name
     * @return File
     */
    public function file($name)
    {
        return $this->addElement('file', $name);
    }

    /**
     * @param null $name
     * @return Submit
     */
    public function submit($name = null)
    {
        return $this->addElement('submit', $name);
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
        return $this->addElement($method, array_shift($args), true);
    }

    /*
     * @param string $type
     * @param string $name
     * @return Element
     */
    protected abstract function addElement($type, $name, $isMacro = false);

    /**
     * @param string $name
     * @return Open
     */
    protected abstract function openForm($name);

    /**
     * @return Close
     */
    protected abstract function closeForm();

    /*
     * Reset all of the properties
     */
    protected abstract function reset();

}