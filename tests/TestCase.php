<?php

use Laraplus\Form\Form;
use Laraplus\Form\Contracts\DataStore;
use Laraplus\Form\Presenters\RawPresenter;
use Laraplus\Form\Contracts\ConfigProvider;

class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var Form
     */
    protected $form;

    public function setUp()
    {
        $presenter = new RawPresenter();
        $dataStore = $this->emptyDataStore();
        $configProvider = $this->emptyConfigProvider();

        $this->form = new Form($presenter, $dataStore, $configProvider);
    }

    protected function emptyDataStore()
    {
        $dataStore = Mockery::mock(DataStore::class);
        $dataStore->shouldReceive('getUrl')->andReturn('/');
        $dataStore->shouldReceive('getToken')->andReturn('secret_token');
        $dataStore->shouldReceive('getOldValue')->andReturn(null);
        $dataStore->shouldReceive('getModelValue')->andReturn(null);
        $dataStore->shouldReceive('getError')->andReturn('Error message');

        return $dataStore;
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
        $close = '<input type="hidden" name="_token" value="secret_token" /></form>';

        return $this->clean($open . $string . $close);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}