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
        $parts = explode('.', $key);
        $offset = $this->config;

        foreach($parts as $part) {
            if(!isset($offset[$part])) return null;

            $offset = $offset[$part];
        }

        return $offset;
    }
}