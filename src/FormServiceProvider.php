<?php namespace Laraplus\Form;

use Illuminate\Support\ServiceProvider;

class FormServiceProvide extends ServiceProvider
{

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
}