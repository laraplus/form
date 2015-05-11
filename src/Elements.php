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

class Elements
{
    protected $open = null;
    protected $close = null;
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
        $element = new Text($name);
        $this->elements[] = $element;

        return $element;
    }

    /**
     * @param string $name
     * @return Password
     */
    public function password($name)
    {
        $element = new Password($name);
        $this->elements[] = $element;

        return $element;
    }

    /**
     * @param string $name
     * @return Password
     */
    public function hidden($name)
    {
        $element = new Hidden($name);
        $this->elements[] = $element;

        return $element;
    }

    /**
     * @param string $name
     * @return Select
     */
    public function select($name)
    {
        $element = new Select($name);
        $this->elements[] = $element;

        return $element;
    }

    /**
     * @param string $name
     * @return Checkbox
     */
    public function checkbox($name)
    {
        $element = new Checkbox($name);
        $this->elements[] = $element;

        return $element;
    }

    /**
     * @param string $name
     * @return CheckboxList
     */
    public function checkboxList($name)
    {
        $element = new CheckboxList($name);
        $this->elements[] = $element;

        return $element;
    }

    /**
     * @param $name
     * @return RadioList
     */
    public function radioList($name)
    {
        $element = new RadioList($name);
        $this->elements[] = $element;

        return $element;
    }

    /**
     * @param $name
     * @return File
     */
    public function file($name)
    {
        $element = new File($name);
        $this->elements[] = $element;

        return $element;
    }


}