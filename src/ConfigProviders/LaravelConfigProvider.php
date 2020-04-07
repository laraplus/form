<?php namespace Laraplus\Form\ConfigProviders;

use Laraplus\Form\Contracts\ConfigProvider;

class LaravelConfigProvider implements ConfigProvider
{
    /**
     * Get configuration by key
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return config('form.' . $key);
    }
}