<?php namespace Laraplus\Form\DataStores;

use Illuminate\Support\MessageBag;
use Laraplus\Form\Contracts\DataStore;

class LaravelDataStore implements DataStore
{
    /**
     * @var ArrayAccess
     */
    protected $model = null;

    /**
     * @var Request
     */
    private $request;

    public function __construct()
    {
        $this->request = app('request');
    }

    /**
     * @param ArrayAccess $model
     */
    public function bind($model)
    {
        $this->model = $model;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getError($name)
    {
        $errors = $this->request->session()->get('errors', new MessageBag);

        if ($errors->has($name)) {
            return $errors->first($name);
        }

        return null;
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getOldValue($name)
    {
        if ($old = $this->request->old($name)) {
            return $old;
        }
        return null;
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getModelValue($name)
    {
        if (isset($this->model[$name])) {
            return $name;
        }
        return null;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $query = $this->request->getQueryString();

        return '/' . trim($this->request->path(), '/') . ($query ? '?' . $query : '');
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->request->session()->getToken();
    }
}