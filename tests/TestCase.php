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
        $presenter = new RawPresenter();
        $dataStore = new PhpDataStore();
        $configProvider = new PhpConfigProvider([]);

        $this->form = new Form($presenter, $dataStore, $configProvider);
    }

    protected function emptyConfigProvider()
    {
        $config = Mockery::mock(ConfigProvider::class);
        $config->shouldReceive('get')->andReturn(null);

        return $config;
    }

    protected function clean($string)
    {
        return str_replace("\n", '', $string);
    }

    protected function wrap($string)
    {
        $open = '<form method="GET" action="/">';
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
    }

    protected function setPostValue($field, $value)
    {
        $_POST[$field] = $value;
    }

    public function tearDown()
    {
        if(isset($_SESSION)) $_SESSION = [];
        if(isset($_POST)) $_POST = [];

        Mockery::close();
    }
}