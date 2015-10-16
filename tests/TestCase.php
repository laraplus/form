<?php

use Laraplus\Form\Contracts\ConfigProvider;
use Laraplus\Form\Form;
use Laraplus\Form\Contracts\DataStore;
use Laraplus\Form\Presenters\RawPresenter;

class TestCase extends PHPUnit_Framework_TestCase
{
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

    public function tearDown()
    {
        Mockery::close();
    }
}