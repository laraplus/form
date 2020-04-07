<?php namespace Laraplus\Form\DataStores;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Laraplus\Form\Contracts\DataStore;

class LaravelDataStore implements DataStore
{
    use RetrievesModelValues;

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
     * @param string $name
     * @return string
     */
    public function getError($name)
    {
        $name = str_replace(['[', ']'], ['.', ''], $name);
        
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
        $name = str_replace(['[', ']'], ['.', ''], $name);
        
        $current = $this->request->input($name);
        $old = $this->request->old($name);

        if(isset($current)) return $current;

        if(isset($old)) return $old;

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
        return $this->request->session()->token();
    }
}
