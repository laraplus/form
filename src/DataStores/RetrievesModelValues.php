<?php namespace Laraplus\Form\DataStores;

trait RetrievesModelValues
{
    /**
     * @var ArrayAccess|array
     */
    protected $model = null;

    /**
     * @param ArrayAccess|array $model
     */
    public function bind($model)
    {
        $this->model = $model;
    }

    /**
     * @param string $name
     * @param null|ArrayAccess|array $offset
     * @return null|string
     */
    public function getModelValue($name, $offset = null)
    {
        $model = isset($offset) ? $offset : $this->model;

        if(($from = strpos($name, '[')) && ($to = strpos($name, ']'))) {
            $newName = substr($name, $from+1, $to-$from-1) . substr($name, $to+1);
            $offset = substr($name, 0, $from);

            if(!isset($model[$offset])) return null;

            return $this->getModelValue($newName, $model[$offset]);
        }

        if (is_array($model) && isset($model[$name])) {
            return $model[$name];
        }

        if(is_object($model) && $model->$name) {
            return $model->$name;
        }

        return null;
    }
}
