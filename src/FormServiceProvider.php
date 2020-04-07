<?php namespace Laraplus\Form;

use Illuminate\Support\ServiceProvider;

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

        $presenter = config('form.presenter', 'Laraplus\Form\Presenters\Bootstrap3Presenter');

        $this->app->bind('Laraplus\Form\Contracts\FormPresenter', $presenter);
        $this->app->singleton('laraplus.form', 'Laraplus\Form\Form');
    }
}
