<?php namespace Laraplus\Form;

use Illuminate\Support\ServiceProvider;
use Laraplus\Form\ConfigProviders\LaravelConfigProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('Laraplus\Form\Contracts\DataStore', 'Laraplus\Form\DataStores\LaravelDataStore');
        $this->app->bind('Laraplus\Form\Contracts\ConfigProvider', 'Laraplus\Form\ConfigProviders\LaravelConfigProvider');
    }

    /**
     * Boot the service provider
     */
    public function boot()
    {
        $config = dirname(__DIR__) . '/config/form.php';
        $this->mergeConfigFrom($config, 'form');
        $this->publishes([$config => config_path('form.php')], 'config');

        $this->app->bind('Laraplus\Form\Contracts\FormPresenter', function() {
            $configOffset = LaravelConfigProvider::$configOffset;
            $presenter = config($configOffset . '.presenter', 'Laraplus\Form\Presenters\Bootstrap3Presenter');

            return new $presenter;
        });
        
        $this->app->singleton('laraplus.form', 'Laraplus\Form\Form');
    }
}
