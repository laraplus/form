<?php namespace Laraplus\Form;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('Laraplus\Form\Contracts\DataStore', 'Laraplus\Form\DataStores\LaravelDataStore');
        $this->app->bind('Laraplus\Form\Contracts\FormPresenter', 'Laraplus\Form\Presenters\RawPresenter');

        $this->app->singleton('laraplus.form', 'Laraplus\Form\Form');
    }

    /**
     * Boot the service provider
     */
    public function boot()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/form.php', 'laraplus.form');
    }

    /**
     * Return an array of provided services
     *
     * @return array
     */
    public function provides()
    {
        return ['laraplus.form'];
    }
}