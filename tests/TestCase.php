<?php

use Laraplus\Form\Form;
use Laraplus\Form\DataStores\PhpDataStore;
use Laraplus\Form\Presenters\RawPresenter;
use Laraplus\Form\Contracts\ConfigProvider;
use Laraplus\Form\ConfigProviders\PhpConfigProvider;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var Form
     */
    protected $form;

    public function setUp()
    {
        $this->form = $this->createForm();
    }

    public function createForm()
    {
        $presenter = new RawPresenter();
        $dataStore = new PhpDataStore();
        $configProvider = new PhpConfigProvider([]);

        return new Form($presenter, $dataStore, $configProvider);
    }

    protected function clean($string)
    {
        return str_replace("\n", '', $string);
    }

    protected function wrap($string)
    {
        $open = '<form method="GET" action="/"><input type="hidden" name="_form" value="test" />';
        $close = '<input type="hidden" name="_token" value="" /></form>';

        return $this->clean($open . $string . $close);
    }

    protected function setError($field, $error)
    {
        $_SESSION['errors'] = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
        $_SESSION['errors'][$field] = $error;
    }

    protected function setToken($token)
    {
        $_SESSION['token'] = $token;
    }

    protected function setOldValue($field, $value)
    {
        $_SESSION['input'] = isset($_SESSION['input']) ? $_SESSION['input'] : [];
        $_SESSION['input'][$field] = $value;
        $_SESSION['input']['_form'] = 'test';
    }

    protected function setPostValue($field, $value)
    {
        $_POST[$field] = $value;

        if($field != '_form') {
            $_POST['_form'] = 'test';
        }
    }

    public function tearDown()
    {
        if(isset($_SESSION)) $_SESSION = [];
        if(isset($_POST)) $_POST = [];

        Mockery::close();
    }
}