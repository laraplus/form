<?php namespace Laraplus\Form\DataStores;

use Laraplus\Form\Contracts\DataStore;

class PhpDataStore implements DataStore
{
    use RetrievesModelValues;

    /**
     * @param string $name
     * @return string
     */
    public function getError($name)
    {
        if(isset($_SESSION['errors'][$name])) {
            return is_array($_SESSION['errors'][$name]) ?
                implode(' ', $_SESSION['errors'][$name]) :
                $_SESSION['errors'][$name];
        }

        return null;
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getOldValue($name)
    {
        if(isset($_POST[$name])) {
            return $_POST[$name];
        }

        if(isset($_SESSION['input'][$name])) {
            return $_SESSION['input'][$name];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $path = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $query = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';

        return $path . $query;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : '';
    }
}