<?php namespace Laraplus\Form;

use Illuminate\Support\ServiceProvider;

class FormServiceProvide extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Laraplus\Form\Contracts\DataStore', 'Laraplus\Form\DataStores\LaravelDataStore');
        $this->app->bind('Laraplus\Form\Contracts\FormPresenter', 'Laraplus\Form\Presenters\RawFormPresenter');

        $this->app->instance('laraplus.form', 'Laraplus\Form\Form');
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