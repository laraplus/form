<?php namespace Laraplus\Form\Contracts;

use ArrayAccess;

interface DataStore
{
    /**
     * @param ArrayAccess $model
     */
    public function bind($model);

    /**
     * @param string $name
     * @return string
     */
    public function getError($name);

    /**
     * @param string $name
     * @return null|string
     */
    public function getOldValue($name);

    /**
     * @param string $name
     * @return null|string
     */
    public function getModelValue($name);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getToken();

}