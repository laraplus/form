<?php namespace Laraplus\Form\ConfigProviders;

use Laraplus\Form\Contracts\ConfigProvider;

class PhpConfigProvider implements ConfigProvider
{
    /**
     * @var array
     */
    private $config;

    /**
     * Initialize configuration
     *
     * @param array $config
     */
    public function __construct(array $config)
    {

        $this->config = $config;
    }

    /**
     * Get configuration by key
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : null;
    }
}