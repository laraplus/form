<?php namespace Laraplus\Form;

use Laraplus\Form\Fields\File;
use Laraplus\Form\Fields\Open;
use Laraplus\Form\Fields\Text;
use Laraplus\Form\Fields\Close;
use Laraplus\Form\Fields\Select;
use Laraplus\Form\Fields\Password;
use Laraplus\Form\Fields\Checkbox;
use Laraplus\Form\Fields\RadioList;
use Laraplus\Form\Fields\CheckboxList;

abstract class Elements
{
    /**
     * @var Open
     */
    protected $open = null;

    /**
     * @var Close
     */
    protected $close = null;

    /**
     * @var array
     */
    protected $elements = [];

    /**
     * @param $name
     * @return Form
     */
    public function open($name)
    {
        $form = new Open($name);
        $this->open = $form;

        return $form;
    }

    /**
     * @return Close
     */
    public function close()
    {
        $form = new Close();
        $this->close = $form;

        return $form;
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
     * @return CheckboxList
     */
    public function checkboxList($name)
    {
        return $this->addElement('checkbox_list', $name);
    }

    /**
     * @param $name
     * @return RadioList
     */
    public function radioList($name)
    {
        return $this->addElement('radio_list', $name);
    }

    /**
     * @param $name
     * @return File
     */
    public function file($name)
    {
        return $this->addElement('file', $name);
    }

    /*
     * @param string $type
     * @param string $name
     */
    protected abstract function addElement($type, $name);

}