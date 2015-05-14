<?php namespace Laraplus\Form\DataStores;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Laraplus\Contracts\DataStore;

class LaravelDataStore implements DataStore {

    /**
     * @var ArrayAccess
     */
    protected $model = null;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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

        if($errors->has($name)) {
            return $errors->get($name);
        }

        return null;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getValue($name)
    {
        if($old = $this->request->old($name)) {
            return $old;
        }
        if(isset($this->model[$name])) {
            return $name;
        }
    }
}